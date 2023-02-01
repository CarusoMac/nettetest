<?php

namespace App\Presenters;


use \Nette\Application\UI\Presenter;
use App\Model\DiscussionManager;
use \Nette\Application\UI\Form;

// discusion presenter je folder z template
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

  //tovarnicka createComponentJmenokomponentykteroumetodavytvari
  public function createComponentDiscussionForm()
  {
    $form = new Form();
    //viz form docs v nette, pridani = add, name=nick, label je druhy parametr
    $form->addText('nick', 'Přezdívka:');
    //pridej text s parametry name a label
    $form->addText('email', 'Email:');
    $form->addTextArea('data', 'Příspěvek');
    $form->addSubmit('insert', 'Vložit');

    //prvni volame objekt / metoda presenteru ktery vola, a metodu kterou pouzije
    $form->onSuccess[] = [$this, 'discussionItemInsert'];
    return $form;
  }


  //reakce naformular, volame manazera, predame mu tri parametry = co bylo vyplneno a zavolame flashmessage, flash
  public function discussionItemInsert(Form $form, $values)
  {
    $values = $form->getValues();
    $this->discussionManager->saveDiscussionItems($values['nick'], $values['email'], $values['data']);
    $this->flashMessage('Příspěvek vložen.');
  }

  public function renderDetail($id)
  {
    $this->template->discussionItem = $this->discussionManager->getDisscussionItem($id);
    $this->template->title = 'Příspěvek';
  }

  public function actionAddPositive($id)
  {
    $this->discussionManager->addPositive($id);
    $this->flashMessage('Pozitivní hodnocení vloženo.');
    $this->redirect('Discussion:');
  }

  public function actionAddNegative($id)
  {
    $this->discussionManager->addNegative($id);
    $this->flashMessage('Negativní hodnocení vloženo.');
    //pokud za dvojteckou neni nic vola se default, pokud neni uveden nazev presenteru vola se homepage
    $this->redirect('Discussion:');
  }
}
