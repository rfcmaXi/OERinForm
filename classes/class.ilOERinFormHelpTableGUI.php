<?php
// Copyright (c) 2017 Institut fuer Lern-Innovation, Friedrich-Alexander-Universitaet Erlangen-Nuernberg, GPLv3, see LICENSE


/**
 * Table of available help pages
 *
 * @author Fred Neumann <fred.neumann@fim.uni-erlangen.de
 */ 
class ilOERinFormHelpTableGUI extends ilTable2GUI {

    /** @var  ilAccessHandler $access */
    protected $access;

    /** @var ilCtrl $ctrl */
    protected $ctrl;

    /** @var  ilLanguage $lng */
    protected $lng;

    /** @var ilTabsGUI */
    protected $tabs;

    /** @var  ilToolbarGUI $toolbar */
    protected $toolbar;

    /** @var ilTemplate $tpl */
    protected $tpl;

    /** @var ilOERinFormPlugin $plugin */
    protected $plugin;

    /** @var ilOERinFormHelp */
    protected $help;


    /**
     * Constructor
     * 
     * @param 	object		parent object
     * @param 	string		parent command
     */
    function __construct($a_parent_obj, $a_parent_cmd = '', $a_template_context = '') 
    {
        global $DIC;

        $this->access = $DIC->access();
        $this->ctrl = $DIC->ctrl();
        $this->lng = $DIC->language();
        $this->tabs = $DIC->tabs();
        $this->toolbar = $DIC->toolbar();
        $this->tpl = $DIC['tpl'];

    	// this uses the cached plugin object
        $this->plugin = ilPlugin::getPluginObject(IL_COMP_SERVICE, 'UIComponent', 'uihk', 'OERinForm');
        $this->help = $this->plugin->getHelp();

		parent::__construct($a_parent_obj, $a_parent_cmd, $a_template_context);

        $this->setTitle($this->plugin->txt('help_pages'));
        $this->setDescription($this->plugin->txt('help_pages_info'));
        $this->addColumn($this->plugin->txt('help_id'));
        $this->addColumn($this->plugin->txt('help_context'));
        $this->addColumn($this->plugin->txt('help_page'));
        $this->addColumn($this->lng->txt('actions'));
        $this->setEnableHeader(true);

        $this->setRowTemplate('tpl.help_pages.html',  $this->plugin->getDirectory());
        $this->prepareData();

    }

    /**
     * Get data and put it into an array
     */
    function prepareData()
    {
        $data = [];
        foreach ($this->help->getAllHelpIds() as $help_id)
        {
            $row = [];
            $row['help_id'] = $help_id;
            $row['help_context'] = $this->plugin->txt('help_page_'.$help_id);
            if ($this->help->isPageAvailable($help_id))
            {
                $page = new ilWikiPage($this->help->getPageId($help_id));
                $row['page_title'] = $page->getTitle();
                //$row['actions'] = $this->plugin->getHelpGUI()->getHelpButton($help_id);
            }
            else
            {
                $row['page_title'] = ' ';
                $row['actions'] = ' ';
            }

            $data[] = $row;
        }

        $this->setData($data);
    }


    function fillRow($a_set)
    {
        parent::fillRow($a_set); // TODO: Change the autogenerated stub
    }
}

?>