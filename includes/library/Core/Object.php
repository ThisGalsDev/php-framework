<?php

namespace Core
{
	class Object
	{
		public function __get($name)
		{
			$method_name = '_get'.$name;
			if( method_exists($this, $method_name) )
				return $this->$method_name();
			
			throw new Exception('Property ['.$name.'] not found on object.');
		}
		
		public function __set($name, $value)
		{
			$method_name = '_set'.$name;
			if( method_exists($this, $method_name) )
				return $this->$method_name($value);
			
			throw new Exception('Property ['.$name.'] not found on type ['.get_class($this).'].');
		}
		
		public function __isset($name)
		{
			$method_name = '_get'.$name;
			if( method_exists($this, $method_name) )
				return $this->$method_name() != null;
			
			return false;
		}
		
		public function __call($name, array $args)
		{
			if( !method_exists($this, $name.'0') )
				throw new Exception('Method ['.$name.'] not found on type ['.get_class($this).'].');
			
			$methods = array();
			$idx = 0;
			while(true)
			{
				if( !method_exists($this, $name.$idx) )
					break;
					
				$m = new \ReflectionMethod($this, $name.$idx);
				$arg_list = $m->getParameters();
				
				$methods[] = array(
					'name' => $name.$idx,
					'reflect' => $m
				);
				
				$idx++;
			}
			
			// sort
			
			$method = $methods[0]['reflect'];
			
			return $method->invokeArgs($this, $args);
		}
		
		public static function __callStatic($name, array $args)
		{
		}
		
		public function __destruct()
		{
			$this->Dispose();
		}
		
		public function Dispose()
		{ }
		
		public function Equals($oOther)
		{
			return $this == $oOther;
		}
		
		public function ReferenceEquals($oOther)
		{
			return $this === $oOther;
		}
		
		public function GetType()
		{
			return new \ReflectionClass($this);
		}
	}
}