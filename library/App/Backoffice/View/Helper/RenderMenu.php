<?php
/**
 * Renders the main menu for the site. 
 *
 * @category App
 * @package App_View
 * @subpackage Helper
 * @copyright Company
 */

class App_Backoffice_View_Helper_RenderMenu extends Zend_View_Helper_Abstract
{
    /**
     * Template for the tabs at the top
     * 
     * @var string
     * @access protected
     */
    protected $_tabLinkTemplate = '<a href="javascript:return false;" title="%1$s">%1$s</a>';
    
    /**
     * Template for the links
     * 
     * @var string
     * @access protected
     */
    protected $_linkTemplate = '<a href="%1$s" title="%2$s">%2$s</a>';
    
    /**
     * Template for the currently selected link
     * 
     * @var string
     * @access protected
     */
    protected $_currentLinkTemplate = '<a class="current" href="%1$s" title="%2$s">%2$s</a>';
    
    /**
     * Convenience method
     * call $this->renderMenu() in the view to access 
     * the helper
     *
     * @access public
     * @return string
     */
    public function renderMenu(){
        $navigation = App_Backoffice_Navigation::getInstance()->getNavigation();
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        
        $menu = array();
        foreach ($navigation as $tab) {
            if(isset($tab['controller'])){
                if(isset($tab['action'])){
                    $url = $baseUrl . '/' . $tab['controller'] . '/' . $tab['action'];
                }else{
                    $url = $baseUrl . '/' . $tab['controller'];
                }
                
                if (isset($page['active']) && $page['active']){
                    $tabLink = sprintf($this->_currentLinkTemplate, $url, $tab['label']);
                } else {
                    $tabLink = sprintf($this->_linkTemplate, $url, $tab['label']);
                }
            }else{
                $tabLink = sprintf($this->_tabLinkTemplate, $tab['label']);
            }
            
            $links = array();
            if(isset($tab['pages'])){
                foreach($tab['pages'] as $page) {
                    if(isset($page['action'])){
                        $url = $baseUrl . '/' . $page['controller'] . '/' . $page['action'];
                    }else{
                        $url = $baseUrl . '/' . $page['controller'];
                    }
                    
                    if (isset($page['active']) && $page['active']){
                        $links[] = sprintf($this->_currentLinkTemplate, $url, $page['label']);
                    } else {
                        $links[] = sprintf($this->_linkTemplate, $url, $page['label']);
                    }
                }
            }
            
            if (isset($tab['active']) && $tab['active']) {
                $li = '<li class="current">' . PHP_EOL . $tabLink . PHP_EOL;
                $li .= !empty($links)? '<ul>' . PHP_EOL . '<li>' . implode('</li>' . PHP_EOL . '<li>', $links) . '</li>' . PHP_EOL . '</ul>' : '';
                $li .= '</li>';
            } else {
                $li = '<li>' . PHP_EOL . $tabLink . PHP_EOL;
                $li .= !empty($links)? '<ul>' . PHP_EOL . '<li>' . implode('</li>' . PHP_EOL . '<li>', $links) . '</li>' . PHP_EOL . '</ul>' : '' ;
                $li .= '</li>';
            }
            
            $menu []= $li;
        }
        
        $xhtml = '<ul id="nav" class="sf-menu">' . PHP_EOL . implode(PHP_EOL, $menu) . PHP_EOL . '</ul>';
        
        return $xhtml;
    }
}