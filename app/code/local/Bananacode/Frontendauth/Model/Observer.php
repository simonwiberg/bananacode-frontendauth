<?php
/* 
 * Simon wiberg
 * simon@bananacode.com.br
 */

class Bananacode_Frontendauth_Model_Observer
{
   
  
   public function checkAccess()
   {
	  if(!$this->isEnabled()){ 
	  	return;
	  }
	  
	  if($this->isAdmin()){
	  	return;
	  }	  
	  
	  if(Mage::getStoreConfigFlag('frontendauth/general/adminlogin') && $this->isLoggedInToAdmin()){
	  	 return;
	  }
	  
	  if(Mage::getStoreConfigFlag('frontendauth/general/enableblacklist') && $this->isBlacklisted()){
	  	$this->denyAccess();
	  }

	  if(Mage::getStoreConfigFlag('frontendauth/general/enablewhitelist') && !$this->isWhitelisted()){
	  	$this->denyAccess();
	  }
   }
   
   
   private function isWhitelisted(){
   	   $remoteHost = $this->getRemoteHost();
	   if(in_array($remoteHost, $this->getWhitelist())){
	   		$this->debugLog("Remote host ".$remoteHost." is on whitelist");
			return true;
	   }
	   $this->debugLog("Remote host ".$remoteHost." is NOT on whitelist");
	   return false;
   }
   
   private function isBlacklisted(){
   	   $remoteHost =  $this->getRemoteHost();
	   if(in_array($remoteHost, $this->getBlacklist())){
	   		$this->debugLog("Remote host ".$remoteHost." is on blacklist");
			return true;
	   }
	    $this->debugLog("Remote host ".$remoteHost." is NOT on blacklist");
	   return false;
   }
   
   private function isAdmin(){
   	  $adminurl = (string)Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');
      $urlstring = Mage::helper('core/url')->getCurrentUrl();
      $url = Mage::getSingleton('core/url')->parseUrl($urlstring);
      if (strstr($url->path, "/{$adminurl}")){
      	 return true;
      }
	  return false;   
   }

	private function isEnabled(){
		return Mage::getStoreConfigFlag('frontendauth/general/enabled');
	}
	
	private function isLoggedInToAdmin(){
	  // get admin session
      Mage::getSingleton('core/session', array('name' => 'adminhtml'))->start();
      $admin_logged_in = Mage::getSingleton('admin/session', array('name' => 'adminhtml'))->isLoggedIn();
      // return to frontend section
      Mage::getSingleton('core/session', array('name' => 'frontend'))->start();
	  if($admin_logged_in){
	  	$this->debugLog("Logged in admin user granted access to frontend");
	  }
	  return $admin_logged_in;
    }
	
	private function denyAccess(){
		die('No access!');
	}

	private function getWhitelist(){
		$stringWhitelist =  trim(Mage::getStoreConfig('frontendauth/general/whitelist'));//"54.88.73.122,127.0.0.1";
		$whitelist = explode(",",$stringWhitelist);
		return $whitelist;
	}
	
	private function getBlacklist(){
		$stringBlacklist = trim(Mage::getStoreConfig('frontendauth/general/blacklist'));
		$whitelist = explode(",",$stringBlacklist);
		return $whitelist;
	}
	
	private function debugLog($string){
		if(Mage::getStoreConfigFlag('frontendauth/general/debuglog')){
			Mage::log($string,null,"frontendauth.log");
		}			
	}

	private function getRemoteHost(){
		$configValue = trim(Mage::getStoreConfig('frontendauth/general/remotehost'));		
		switch ($configValue) {
			case '1':
				return $_SERVER['HTTP_CLIENT_IP'];
				break;
			case '2':
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
				break;
			default:
				return Mage::helper('core/http')->getRemoteAddr();
				break;
		}
	}
	
}
