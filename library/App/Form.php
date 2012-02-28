<?php
/**
 * Default parent form for all the forms in the application
 *
 * @category App
 * @package App_Form
 * @copyright company
 */

abstract class App_Form extends Zend_Form
{
  
	/**
	 * Array of default element decorators
	 */
	protected $_defaultElementDecorators = null ;
	
	/**
	 * Enable or disable the default decorators
	 */
	protected $_disableDefaultDecorators = false ;

	/**
	 * Standard elements list
	 */
	protected $_standardElements = array(
	  'Zend_Form_Element_Button',
	  'Zend_Form_Element_Captcha',
	  'Zend_Form_Element_Checkbox',
	  'Zend_Form_Element_File',
	  'Zend_Form_Element_Multiselect',
	  'Zend_Form_Element_Password',
	  'Zend_Form_Element_Select',
	  'Zend_Form_Element_Text',
	  'Zend_Form_Element_Textarea',
	  'Zend_Form_Element_Xhtml',
	  'Zend_Form_DisplayGroup',
	) ;
	
	/**
	 * Hidden elements list
	 */
	protected $_hiddenElements = array(
		'Zend_Form_Element_Hidden',
    'Zend_Form_Element_Hash',
	) ;

	/**
	 * Action elements list (no label displayed)
	 */
	protected $_actionElements = array(
		'Zend_Form_Element_Image',
		'Zend_Form_Element_Submit',
		'Zend_Form_Element_Reset',
	) ;
	
	/**
	 * Multi elements list
	 */
	protected $_multiElements = array(
		'Zend_Form_Element_Multi',
		'Zend_Form_Element_MultiCheckbox',
		'Zend_Form_Element_Radio',
	) ;
	
	public function __construct($options = null)	{
		if (is_array($options)) {
                	$this->setOptions($options);
		} elseif ($options instanceof Zend_Config) {
                	$this->setConfig($options);
		}

		// Init the default decorators
		$this->initDefaultElementsDecorators() ;

		// Extensions...
		$this->init();

		$this->loadDefaultDecorators();
	}    
  
    /**
     * Convenience method to recognize translatable text with gettext
     *
     * @param string $text 
     * @return void
     */
    public function t($text){
        return $text;
    }
    
    
    /**
     * Set to true if you do not want to use the default decorators
     *
     * @param boolean $flag
     * @return \App_Form 
     */
	public function setDisableDefaultDecorators($flag)	{
		$this->_disableDefaultDecorators = (bool) $flag ;
		return $this ;
	}
  
	
  /**
   *
	 * Overriding the standard addElement method and call addElement
	 * with the default decorators if needed
   * 
   * @param  string|Zend_Form_Element $element
   * @param  string $name
   * @param  array|Zend_Config $options
   * @return \App_Form
   */
	public function addElement($element, $name = null, $options = null)	{
		if ($this->_disableDefaultDecorators)	{
			return parent::addElement($element, $name, $options) ;
		}

		return $this->addElementWithDefaultDecorators($element, $name, $options) ;
	}

	/**
	 * Same as addElement but set the elements decorators
   * 
   * @param  string|Zend_Form_Element $element
   * @param  string $name
   * @param  array|Zend_Config $options
   * @return \App_Form
   */
	public function addElementWithDefaultDecorators($element, $name = null, $options = null)	{
		if (is_string($element)) {
			$element = $this->createElement($element, $name, $options) ;
		}
    
	  if (!$options || !array_key_exists('decorators', $options))	{
  	  $element->setDecorators($this->getDefaultElementDecorators(get_class($element))) ;
	  }
  	
  	return parent::addElement($element, $name, $options) ;
	}
  
  
  /**
   * 
   * Set decorators for an element class
   *
   * @param string $className
   * @param string $decorators
   * @return \App_Form 
   */
	public function setDefaultElementDecorators($className, $decorators)	{
 		$this->_defaultElementDecorators[$className] = $decorators ;
		return $this ;
	}


  /**
   * 
   * Get decorators from an element class name
   *
   * @param string $className
   * @return array 
   */
	public function getDefaultElementDecorators($className)	{
		return $this->_defaultElementDecorators[$className] ;
	}

	/**
	 * Set decorators for an array of element class
	 */
	public function setDefaultElementsDecorators(array $classNames, $decorators)	{
  		foreach ($classNames as $className)	{
  			$this->setDefaultElementDecorators($className, $decorators) ;
  		}
	  	return $this ;
	}
	
	/**
	 * Initialize the default element decorators
	 */
	public function initDefaultElementsDecorators()	{
    
    
    $this->addPrefixPath('App_Form_Decorator', 'App/Form/Decorator/', 'decorator'); 
    
		// Standard
		$standardDecorators = array(
			'ViewHelper',
       array('ErrorSpan', array('tag' => 'span')),
       array('decorator' => array('InputWrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'controls')),       
       array('Label','options' => array('class' => 'control-label')),
			 array('decorator' => array('Wrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'control-group')) 
		) ;
		
		$this->setDefaultElementsDecorators($this->_standardElements, $standardDecorators) ;

		// Hidden
		$hiddenDecorators = array(
			'ViewHelper',
			array('decorator' => array('Wrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'hiddenHolder')) 
		) ;

		$this->setDefaultElementsDecorators($this->_hiddenElements, $hiddenDecorators) ;

		// Buttons
		$actionDecorators = array(
			'ViewHelper', 
			array('decorator' => array('Wrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'form-actions')) 
		) ;

		$this->setDefaultElementsDecorators($this->_actionElements, $actionDecorators) ;

		// Multi Form Elements
		$multiDecorators = array(
			'ViewHelper',
			array('decorator' => array('MultiWrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'controls')),
			array('Label','options' => array('class' => 'control-label')), 
			array('decorator' => array('Wrapper' => 'HtmlTag'), 'options' => array('tag' => 'div', 'class' => 'control-group')) 
		) ;

		$this->setDefaultElementsDecorators($this->_multiElements, $multiDecorators) ;
        
	}
	
	/**
	 * Load the default decorators for the current form
	 */
	public function loadDefaultDecorators()	{
    
		if ($this->loadDefaultDecoratorsIsDisabled()) {
      return;
		}
    
   $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset',
        ));    

		$decorators = $this->getDecorators();
		if (empty($decorators)) {
			$this->addDecorator('FormElements')
			     ->addDecorator('Form');
		}
	}       
    
}

