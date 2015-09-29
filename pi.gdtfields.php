<?php 

/**
 *	Gdtfields Class
 *
 *	@package		ExpressionEngine
 *	@author			Richard Whitmer/Godat Design, Inc.
 *	@copyright		(c) 2015, Godat Design, Inc.
 *	@license		
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *	The above copyright notice and this permission notice shall be included in all
 *	copies or substantial portions of the Software.
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *	SOFTWARE.
 *	
 *	@link			http://godatdesign.com
 *	@since			Version 2.10.1
 */
 
 // ------------------------------------------------------------------------

/**
 * Good at Fields Plugin
 *
 * @package			ExpressionEngine
 * @subpackage		third_party
 * @category		Plugin
 * @author			Richard Whitmer/Godat Design, Inc.
 * @copyright		Copyright (c) 2015, Godat Design, Inc.
 * @link			http://godatdesign.com
 */
  
 // ------------------------------------------------------------------------

	$plugin_info = array(
	    'pi_name'         => 'Good at Fields',
	    'pi_version'      => '1.0.0',
	    'pi_author'       => 'Richard Whitmer/Godat Design, Inc.',
	    'pi_author_url'   => 'http://godatdesign.com/',
	    'pi_description'  => '
	    Functions for accessing custom fields data from templates
	    ',
	    'pi_usage'        => Gdtfields::usage()
	);
	

	class  Gdtfields {
		
			public $return_data		= "";
			public $field_name;
		
			public function __construct()
			{
				$this->EE =& get_instance();
				
				$this->field_name = ee()->TMPL->fetch_param('field_name');
			}
			
			// ------------------------------------------------------------------------
			
			/**
			 * Return parsed database row values for a custom field field_name
			 */
			 public function channel_field()
			 {
			 	$data = $this->channel_field_data();
			 	
			 	if(count($data)==0)
				 {
					 return ee()->TMPL->no_results();
				 	} else {
					return ee()->TMPL->parse_variables(ee()->TMPL->tagdata,array($data));
				}
				 
			 }
			 
			 // ------------------------------------------------------------------------

			/**
			 * Parse field list items for template.
			 */
			 public function field_list_items()
			 {
				 $data = array();
				 $str = trim($this->field_list_items_data());
				 $str = preg_replace("/(\\r|\\n){1,}/","\n",$str);
				 $vals = explode("\n",$str);
				 
				 if(count($vals)==0)
				 {
					return ee()->TMPL->no_results(); 
				 } else {
					 foreach($vals as $item)
					 {
						 $data[] = array('field_list_item'=>$item);
					 }
				 }
				 
				 return ee()->TMPL->parse_variables(ee()->TMPL->tagdata,$data);
			 }
			 
			 // ------------------------------------------------------------------------
			 			 
			 /**
			  * Get database row field values for a custom field field_name
			  * @return array
			  */
			  private function channel_field_data()
			  {
				 ee()->db->select('*');
				 ee()->db->from('channel_fields');
				 ee()->db->where('field_name',$this->field_name);
				 ee()->db->limit(1);
				 $query = ee()->db->get();
				 if($query->num_rows()==1)
				 {
					 return $query->row_array();
				 } else {
					 return array();
				 }
			   }
			
			// ------------------------------------------------------------------------

			/**
			 * Get field_list_items value
			 * @return string
			 */
			 private function field_list_items_data()
			 {
				 ee()->db->select('field_list_items');
				 ee()->db->where('field_name',$this->field_name);
				 ee()->db->limit(1);
				 ee()->db->from('channel_fields');
				 $query = ee()->db->get();
				 
				 if($query->num_rows()==1)
				 {
					return $query->row()->field_list_items; 
				 } else {
					return ''; 
				 } 
			 }
			 
			 // ------------------------------------------------------------------------
			
			/**
			 *	Return plugin usage documentation.
			 *	@return string
			 */
			static function usage()
			{
				
					ob_start();  ?>
					
			------------------------------------------------------
			DESCRIPTION
			------------------------------------------------------

			Return data about channel fields parsed for output to 
			templates.

			------------------------------------------------------
			TAG PAIRS
			------------------------------------------------------
			
			{exp:gdtfields:field_list_items}
			
			 - Return field_list_items (eg. for an dropdown)

			Parameters:

			field_name="{channel_field_name}" : Required
		
			{exp:gdtfields:field_list_items field_name="{channel_field_name}"}
				{field_list_item}
			{exp:gdtfields:field_list_items}

			#######################################################
			
			{exp:gdtfields:channel_field}
			
			 - Return database row values for a channel field as
			   tags.
			   
			   Parameters:
			   field_name="{channel_field_name}" : Required
			 
			 {exp:gdtfields:channel_field field_name="{channel_field_name}"}
			 	{field_id}
			 	{site_id}
			 	{field_name}
			 	{field_label}
			 	{field_instructions}
			 	{field_type}
			 	{field_list_items}
			 	{field_max}
			 	{field_required}
			 	{field_text_direction}
			 	{field_search}
			 	{field_hidden}
			 	{field_fmt}
			 	{field_order}
			 	{field_content_type}
			 {/exp:gdtfields:channel_field}
			 
			 ------------------------------------------------------

					<?php
					 $buffer = ob_get_contents();
					 ob_end_clean();
					
					return $buffer;	
			}
	}
/* End of file pi.gdtfields.php */
/* Location: ./system/expressionengine/third_party/gdtfields/pi.gdtfields.php */
