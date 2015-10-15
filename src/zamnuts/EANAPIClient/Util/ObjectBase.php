<?php

namespace zamnuts\EANAPIClient\Util;

class ObjectBase {

	public function __get($name) {
		if ( method_exists($this,'get__'.$name) ) {
			return call_user_func(array($this,'get__' . $name));
		}
		return null;
	}

	public function __set($name,$value) {
		if ( method_exists($this,'set__'.$name) ) {
			call_user_func(array($this,'set__' . $name),$value);
		}
	}

	public function __isset($name) {
		$isset = isset($this->{$name});
		if ( !$isset ) {
			if ( method_exists($this,'get__'.$name) ) {
				$isset = $this->{'get__'.$name}() !== null;
			}
		}
		return $isset;
	}

	public function __unset($name) {
		$this->{$name} = null;
	}

}
