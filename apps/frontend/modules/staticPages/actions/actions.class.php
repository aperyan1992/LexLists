<?php

/**
 * staticPages actions.
 *
 * @package    LexLists
 * @subpackage staticPages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticPagesActions extends sfActions {

    /**
     * Executes help action
     *
     * @param sfRequest $request A request object
     */
    public function executeHelp(sfWebRequest $request) {

    	//save info in log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
      
        $custom_logger->info("Directory - Help");
        
    }

}
