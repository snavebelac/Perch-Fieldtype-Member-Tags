<?php
/*
 * A field type for Member tags
 * 
 * @author Caleb Evans
 */
class PerchFieldType_membertags extends PerchAPI_FieldType
{
    /*
     * Output the form fields for the edit page
     *
     * @param array $details 
     * @return void
     */
    public function render_inputs($details=array())
    {
        $id  = $this->Tag->input_id();
        $val = '';
        if (isset($details[$id]) && $details[$id]!='') {
            $json = $details[$id];
            $val  = $json['tag']; 
        }

		$DB = PerchDB::fetch();

        $sql = 'SELECT * FROM '.PERCH_DB_PREFIX.'members_tags ORDER BY tagDisplay';
		$memberTags = $DB->get_rows($sql);

        $opts   = array();
        $opts[] = array('label'=>'', 'value'=>'');

        if (PerchUtil::count($memberTags)) {
            foreach($memberTags as $memberTag) {
                $opts[] = array('label'=>$memberTag['tagDisplay'], 'value'=>$memberTag['tag']);
            }
        }
       
        if(PerchUtil::count($opts)) {
        	$s = $this->Form->select($id, $opts, $val);      	
        } else {
        	$s = '-';
        }
        
        return $s;
    }
      
	/*
	* Read in the form input, prepare data for storage in the database.
	*
	* @param string $post 
	* @param object $Item 
	* @return void
	*/
    public function get_raw($post=false, $Item=false) 
    {
        $store  = array();

        $id = $this->Tag->id();

        if ($post === false) $post = $_POST; 
        if (isset($post[$id])) {
    		$store['tag'] = $post[$id];
        }
        return $store;
    }
    
	/*
	* Take the raw data input and return process values for templating
	*
	* @param string $raw 
	* @return void
	*/
    public function get_processed($raw=false)
    {    
        if (is_array($raw) && isset($raw['tag'])) { 
            return $raw['tag'];
        }

        return $raw;
    }
    
	/*
	* Get the value to be used for searching
	*
	* @param string $raw 
	* @return void
	*/
    public function get_search_text($raw=false)
    {
		return false;
    }

}