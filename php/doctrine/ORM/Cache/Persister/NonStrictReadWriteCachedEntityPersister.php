<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Cache\Persister;

use Doctrine\ORM\Cache\EntityCacheKey;

use Doctrine\Common\Util\ClassUtils;

/**
 * Specific non-strict read/write cached entity persister
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @since 2.5
 */
class NonStrictReadWriteCachedEntityPersister extends AbstractEntityPersister
{
    /**
     * {@inheritdoc}
     */
    public function afterTransactionComplete()
    {
        $isChanged = false;

        if (isset($this->queuedCache['insert'])) {
            foreach ($this->queuedCache['insert'] as $entity) {
                $class      = $this->class;
                $className  = ClassUtils::getClass($entity);

                if ($className !== $this->class->name) {
                    $class = $this->metadataFactory->getMetadataFor($className);
                }

                $key        = new EntityCacheKey($class->rootEntityName, $this->uow->getEntityIdentifier($entity));
                $entry      = $this->hydrator->buildCacheEntry($class, $key, $entity);
                $cached     = $this->region->put($key, $entry);
                $isChanged  = $isChanged ?: $cached;

                if ($this->cacheLogger && $cached) {
                    $this->cacheLogger->entityCachePut($this->regionName, $key);
                }
            }
        }

        if (isset($this->queuedCache['update'])) {
            foreach ($this->queuedCache['update'] as $entity) {
                $class      = $this->class;
                $className  = ClassUtils::getClass($entity);

                if ($className !== $this->class->name) {
                    $class = $this->metadataFactory->getMetadataFor($className);
                }

                $key        = new EntityCacheKey($class->rootEntityName, $this->uow->getEntityIdentifier($entity));
                $entry      = $this->hydrator->buildCacheEntry($class, $key, $entity);
                $cached     = $this->region->put($key, $entry);
                $isChanged  = $isChanged ?: $cached;

                if ($this->cacheLogger && $cached) {
                    $this->cacheLogger->entityCachePut($this->regionName, $key);
                }
            }
        }

        if (isset($this->queuedCache['delete'])) {
            foreach ($this->queuedCache['delete'] as $key) {
                $this->region->evict($key);

                $isChanged = true;
            }
        }

        if ($isChanged) {
            $this->timestampRegion->update($this->timestampKey);
        }

        $this->queuedCache = array();
    }

    /**
     * {@inheritdoc}
     */
    public function afterTransactionRolledBack()
    {
        $this->queuedCache = array();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->persister->delete($entity);

        $this->queuedCache['delete'][] = new EntityCacheKey($this->class->rootEntityName, $this->uow->getEntityIdentifier($entity));
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        $this->persister->update($entity);

        $this->queuedCache['update'][] = $entity;
    }
}
