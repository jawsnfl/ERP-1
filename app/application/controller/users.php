<?php

/**
 *
 * @author Marcin
 *
 */
namespace Application\Controller {

	use Application\Controller as Controller;
	use Framework\Registry as Registry;
	use Framework\RequestMethods as RequestMethods;
	use Framework\Session\Driver\Server;
	use Framework\Request;

	/**
	 *
	 * @author Marcin
	 *         @NOTE
	 *         W ten sposób można zapisać podstawę działania kontrolerów.
	 *         Za pomocą wpisów w komentarzach przez deklaracją
	 *         można inicjować kolejność kroków i wymagać dla podnoszenia sie funkcji
	 *        
	 */
	class Users extends Controller {
		
		/**
		 * @readwrite
		 */
		protected $_parameters;
		
		/**
		 *
		 * @param unknown $options        	
		 */
		public function __construct($options) {
			/**
			 */
			$this->_parameters = $options ['parameters'];
			// $database = new Framework\Database();
			// $database->initialize();
		}
		
		/**
		 * @once
		 * @protected
		 *
		 * Wykonywana jest inicjalizacja wszystkiego co może być potrzebne.
		 *
		 * @TODO
		 * Włącznie z przekazaniem dalszych danych dla Smatry
		 */
		public function init() {
		}
		
		/**
		 * @protected
		 *
		 * Wykonywane są wszystkie funkcje związane z kontrolą uwierzytelniania
		 *
		 * @TODO
		 * Budowa oddzielnej klasy autentykacji.
		 * W tym miejscy jedynie jej uruchmienie.
		 */
		public function authenticate() {
			// $session = Registry::get("session");
			
			// var_dump($session);
			// var_dump($session->get("user"));
			
			// if (empty($session->get("user"))) {
			
			// header("Location: ?url=users/index");
			// exit();
			// }
			
			/**
			 */
			// $configuration = Registry::get("configuration");
			// $database = Registry::get("database");
			$session = Registry::get ( "session" );
			
			if ($session->getup ( 'user' )) {
				
				header ( "Location: ?url=home/index" );
				// print 'nie jest zalogowany';
			} elseif (RequestMethods::get ( url ) === 'users/index') {
				// nic nie robi
			} else {
				
				header ( "Location: ?url=users/index" );
			}
			// var_dump($session);
		}
		
		/**
		 * @once
		 * @protected
		 */
		public function notify() {
		}
		
		/**
		 * @before init, authenticate,
		 * @after notify
		 */
		public function index() {
		}
		
		/**
		 * @before init
		 * @after notify
		 */
		public function logout() {
			$session = Registry::get ( "session" );
			$session->setup ( "user", FALSE );
			header ( "Location: ?url=users/index" );
			exit ();
		}
		
		/**
		 * @before init
		 * @after notify
		 */
		public function login() {
			if (RequestMethods::post ( "login" )) {
				
				/**
				 * @TODO
				 * - sprawdzić działanie requestmethods
				 * - koniecznie przez requestami zbudować form logowania :D
				 */
				$name = RequestMethods::post ( "name" );
				$password = RequestMethods::post ( "password" );
				
				// var_dump($name);
				// var_dump($password);
				
				/**
				 * @TODO
				 * - zmienić odwołanie dla view na zgodne z aktualnym
				 * - poprawić komunukacje z widokiem
				 */
				// $view = $this->getActionView();
				$error = false;
				if (empty ( $name )) {
					// $view->set("name", "name not provided");
					$error = true;
				}
				if (empty ( $password )) {
					// $view->set("password_error", "Password not provided");
					$error = true;
				}
				if (! $error) {
					
					/**
					 * @TODO
					 * - zbudować zapytanie zgodne z aktualną uproszczoną metodą dostępu
					 * do bazy danych
					 */
					// $user = User::first(array(
					// "email = ?" => $name,
					// "password = ?" => $password,
					// "live = ?" => true,
					// "deleted = ?" => false
					// ));
					
					if ($name === "test" and $password === "test1") {
						$user = TRUE;
					}
					
					/**
					 * @TODO
					 * - wyłączyć rejestrację zmiennej
					 * - przepisać header location na zgodne z aktualnym
					 * lub zrobić przeniesienie dla ref (ale chyba nie będzie potrzeby)
					 */
					if (! empty ( $user )) {
						$session = Registry::get ( "session" );
						$session->setup ( "user", TRUE );
						header ( "Location: ?url=home/index" );
						exit ();
					} else {
						
						/**
						 * @TODO
						 * - obsłużyć błędy logowania
						 */
						// $view->set("password_error", "Email address and/or password are incorrect");
						
						header ( "Location: ?url=users/index" );
						exit ();
					}
					exit ();
				}
			}
		}
		
		/**
		 * @before init, authenticate,
		 * @after notify
		 */
		public function profile() {
			$session = Registry::get ( "session" );
			$user = unserialize ( $session->get ( "user", null ) );
			if (empty ( $user )) {
				$user = new StdClass ();
				$user->first = "Mr.";
				$user->last = "Smith";
			}
			$this->getActionView ()->set ( "user", $user );
		}
	}
}