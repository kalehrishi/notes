<?php

namespace Notes\Response;

use Notes\Encodeable\Encodeable as Encodeable;

class Response  extends Encodeable
{
	public function to_json($response)
	{  
        return $this->encode($response);	  	
	}
}
