<?php
/**
 * Decorator that displays error message the bootstrap way
 * 
 *
 * @category App
 * @package App_Form
 * @subpackage Decorator
 * @copyright company
 */

class App_Form_Decorator_ErrorSpan extends Zend_Form_Decorator_Abstract
{
  
  /**
     * Default position
     * 
     * @var string
     * @access protected
     */
    protected $_placement = 'APPEND';
    
    /**
     * Overrides render() in Zend_Form_Decorator_Abstract
     * 
     * @param mixed $content 
     * @access public
     * @return void
     */
    public function render($content){
      
      
        $element = $this->getElement();
        
                
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $errors = $element->getMessages();
        if (empty($errors)) {
            return $content;
        }
        
        // add error class to the main wrapper
        $element->getDecorator('Wrapper')->setOption('class','control-group error');
   
        $placement  = $this->getPlacement();
        $separator  = $this->getSeparator();
        $options    = $this->getOptions();
        $tag        = "span";
        $tagClass   = 'help-inline';
         
        
        $formErrors = $view->getHelper('formErrors');
        $formErrors->setElementEnd('');
        $formErrors->setElementSeparator('');
        $formErrors->setElementStart('');
        
        
        $errors = $formErrors->formErrors($errors, $options);
 

        if (null !== $tag) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();            
            if (null !== $tagClass) {
                $decorator->setOptions(array(
                    'tag'   => $tag,
                    'class' => $tagClass));
            } else {
                $decorator->setOptions(array(
                    'tag' => $tag,
                    ));
            }
            $errors = $decorator->render($errors);
        }

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
            case self::PREPEND:
                return $errors . $separator . $content;
        }
        
    }
    
}
