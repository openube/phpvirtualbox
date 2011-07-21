<?php
/*
 * phpVirtualBox configuration
 *
 */
class phpVBoxConfig {

/* Username / Password for system user that runs VirutalBox */
var $username = 'vbox';
var $password = 'password';
var $location = 'http://127.0.0.1:18083/';

/* See languages folder for more language options */
var $language = 'en_us';


/*
 *
 * Not-so-common options / tweeking
 *
 */

// Multiple servers example config. Uncomment (remove /* and */) to use.
// Add ALL the servers you want to use. Even if you have the server set
// above. The default server will be the first one in the list.
/*
var $servers = array(
	array(
		'name' => 'London',
		'username' => 'user',
		'password' => 'pass',
		'location' => 'http://192.168.1.1:18083/'
	),
	array(
		'name' => 'New York',
		'username' => 'user2',
		'password' => 'pass2',
		'location' => 'http://192.168.1.2:18083/'
	),
);
*/
// Default host/ip to use for console
//var $consoleHost = '192.168.1.40';

// Disable "preview" box
//var $noPreview = true;

// Default preview box update interval in seconds
//var $previewUpdateInterval = 30;

// Preview box pixel width
var $previewWidth = 180;

/*
Allow to prompt deletion harddisk files on removal from Virtual Media Manager.
If this is not set, files are always kept. If this is set, you will be PROMPTED
to decide whether or not you would like to delete the harddisk file(s) when you
remove a harddisk from virtual media manager. You may still choose not to delete
the file when prompted.
*/
var $deleteOnRemove = true;

/*
 * File / Folder browser settings
 */

// Restrict file types
var $browserRestrictFiles = '.iso,.vdi,.vmdk,.img,.bin,.vhd,.hdd,.ovf,.ova';

// Restrict locations / folders
#var $browserRestrictFolders = 'D:\\,C:\\Users\\Ian'; // Or something like '/home/vbox,/var/ISOs'

// Force use of local, webserver based file browser instead of going through vboxwebsrv
#var $browserLocal = true;

// Disable file / folder browser.
#var $browserDisable = true;

/*
 * Misc
 */

/* Disable any of phpVirtualBox's main tabs */
#var $disableTabVMSnapshots = true; // Snapshots tab
#var $disableTabVMConsole = true; // Console tab

/* Screen resolutions for console tab */
var $consoleResolutions = '640x480,800x600,1024x768';

/* Max number of network cards per VM. Do not set above VirtualBox's limit (typically 8) or below 1 */
var $nicMax = 4;

/* Enable Acceleration configuration (normally hidden in the VirtualBox GUI) */
var $enableAccelerationConfig = true;

/* Custom VMList sort function in JavaScript */
/* This places running VMs at the top of the list
var $vmListSort = 'function(a,b) {
	if(a.state == "Running" && b.state != "Running") return -1;
	if(b.state == "Running" && a.state != "Running") return 1;
	return strnatcasecmp(a.name,b.name);
}';
*/


/*
 * Cache tweeking.
 *
 * NOT a good idea to set any of these unless asked to do so.
 */
#var $cachePath = '/tmp';

/*
 * Cache timings

var $cacheExpireMultiplier = 1;
var $cacheSettings = array(
		'getHostDetails' => 86400, // "never" changes
		'getGuestOSTypes' => 86400,
		'getSystemProperties' => 86400,
		'getInternalNetworks' => 86400,
		'getMediums' => 600,
		'getVMs' => 2,
		'__getMachine' => 7200,
		'__getNetworkAdapters' => 7200,
		'__getStorageControllers' => 7200,
		'__getSharedFolders' => 7200,
		'__getUSBController' => 7200,
);
*/

/* END SETTINGS - BEGIN CLASS CODE */

/*
 * Multiple server functionality
 */
function __construct() {
	// Ignore any server settings if we have servers
	// in the servers array
	if(is_array($this->servers) && is_array($this->servers[0])) {
		unset($this->location);
		unset($this->user);
		unset($this->pass);
	}
	// Set to selected server based on browser cookie
	if(@$_COOKIE['vboxServer'] && is_array($this->servers) && count($this->servers)) {
		foreach($this->servers as $s) {
			if($s['name'] == $_COOKIE['vboxServer'])
				foreach($s as $k=>$v) $this->$k = $v;
		}
	// If servers is not an array, set to empty array
	} elseif(!is_array($this->servers)) {
		$this->servers = array();
	}
	// We still have no server set, use the first one from
	// the servers array
	if(!$this->location && @is_array($this->servers[0])) {
		foreach($this->servers[0] as $k=>$v) $this->$k = $v;
	}
	// Make sure name is set
	if(!$this->name) {
		$this->name = parse_url($this->location);
		$this->name = $this->name['host'];
	}
	$this->key = md5($this->location.$this->username);
}

}


