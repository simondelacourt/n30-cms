<?php

	class installer
	{
		public $errors;
		
		public function __construct ()
		{
		}
		
		
		public function showStepTest ()
		{
			include "./templates/s1.php";
		}
		
		public function showStepConfigure ()
		{
			
			
		}
		public function showStepSettings ()
		{
			
		}
		
		public function checkWritable ($file)
		{
			if (!is_writable("../" . $file))
			{
				$this->errors['writable'][] = $file;
			}
		}
		
		private function createAdmin ()
		{
			
		}
		private function installTemplates()
		{
			
		}
		private function installLanguages ()
		{
			
			
		}
		
		
		
		private function checkSQLConnection ($host, $username, $password)
		{
			
		}
		private function checkSQLDB ($database)
		{
			
		}
		private function getConnectors ()
		{
			
		}
		private function importSQL ()
		{
			
		}
		
		
		/*
		 * layout
		 */
		private function showErrors ($type)
		{
			if (isset($this->errors[$type]))
			{
				$e = '<ul>';
				foreach ($this->errors[$type] as $error)
				{
					$e .= "<li>" . htmlspecialchars($error) . "</li>";
				}
				$e .= "</ul>";
				return ($e);
			}
			else
			{
				return (null);
			}
		}
	}
?>