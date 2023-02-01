<?php

namespace App\Presenters;


use \Nette\Application\UI\Presenter;
use App\Model\DiscussionManager;
use \Nette\Application\UI\Form;

class DiscussionPresenter extends \Nette\Application\UI\Presenter
{
  /**
   * @var \App\Model\DiscussionManager
   */
  private $discussionManager;

  function __construct(DiscussionManager $discussionManager)
  {
    $this->discussionManager = $discussionManager;
    parent::__construct();
  }

  public function renderDefault()
  {
    $this->template->discussionItems = $this->discussionManager->getDisscussionItems();
    $this->template->title = 'Seznam příspěvků';
  }
}
