<?php

class CampaignsController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
	}
	
	/**public function edit($campaignId = null){
		if (isset($this->userId)){
			
			if (!empty($this->data)){
				
				$campaign = $this->Nodes->find(array('type' => 'Campaign', 'Privileges.creator' => $this->userId, 'Privileges.id' => $campaignId),array(),true);
				
			if(empty($campaign)) {
					$this->Session->setFlash('something is wrong');
					$this->redirect('/');
				}
	
				$this->data['Privileges'] = $campaign[0]['Privileges'];
	
				if($this->data['Node']['published'] == 1) {
					$this->data['Privileges']['privileges'] = '755'; // Set basic privileges
				} else {
					$this->data['Privileges']['privileges'] = '700'; // Set privileges so that other users cant read it
				}
	
				$this->data['Node']['type'] = 'Content';
				$this->data['Node']['id'] = $campaignId;
				$this->data['Node']['class'] = $campaign[0]['Node']['class'];
	
				//$this->data['Privileges']['creator'] = NULL;
				$this->Content_->setAllContentDataForSave($this->data);
	
				$this->Tag_->setTagsForSave($this->data['Tags']['tags'],array('privileges' => 555, 'creator' => $this->userId));
				$this->Company_->setCompaniesForSave($this->data['Companies']['companies'],array('privileges' => 555, 'creator' => $this->userId));
	
				$contentBeforeSave = $content;
				$childsToDelete = $contentBeforeSave[0]['Child'];
	
				foreach($childsToDelete as $key => $child) {
					foreach($this->Tag_->getNewAndExistingTags() as $tag) {
						if($child['id'] == $tag['Node']['id']) {
							unset($childsToDelete[$key]); continue 2;
						}
					}
					foreach($this->Company_->getNewAndExistingCompanies() as $company) {
						if($child['id'] == $company['Node']['id']) {
							unset($childsToDelete[$key]); continue 2;
						}
					}
				}
	
				if($this->Content_->saveContent() !== false) {
					//If saving the content was successfull then...
						
					$this->Content_->removeChildsFromContent($childsToDelete);
					$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
					$this->Company_->linkCompaniesToObject($this->Content_->getContentId());
						
					$errors = array();
					if(empty($errors)) {
						$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
	
					} else {
						$this->Session->setFlash('Your content has NOT been successfully saved.');
					}
	
					if($this->Content_->getContentPublishedStatus() === "1") {
						$this->redirect(array('controller' => 'contents', 'action' => 'view', $this->Content_->getContentId()));
					} else {
						$this->redirect(array('controller' => 'contents', 'action' => 'edit',$contentId));
					}
	
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
					$this->redirect('edit/'.$contentId);
				}
			} else {
				if($contentId == -1) {
					$this->redirect('/');
				}
				$this->Nodes->cache = false;
				$content = $this->Nodes->find(array('type' => 'Content', 'Contents.id' => $contentId),array(),true);
	
				if(empty($content)) {
					$this->Session->setFlash('Invalid content ID');
					$this->redirect('/');
				} else {
					$this->Content_->setAllContentDataForEdit($content[0]);
					$editData = $this->Content_->getContentDataForEdit();
					$this->data = $editData;
				}
				$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
				$this->set('content_type',$content[0]['Node']['class']);
			}
		} else {
			$this->redirect('/');
		}
	}
	
	
	***/
	
	
	
	
	
	
	
	

	public function edit($campaignId = null) {
		$this->Campaign->id = $campaignId;
		if (!$this->Campaign->exists()) {
			throw new NotFoundException(__('Invalid campaign'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Campaign->save($this->request->data)) {
				$this->Session->setFlash(__('The campaign has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The campaign could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Campaign->read(null, $id);
		}
		$comments = $this->Campaign->Comment->find('list');
		$contents = $this->Campaign->Content->find('list');
		$files = $this->Campaign->File->find('list');
		$flags = $this->Campaign->Flag->find('list');
		$groups = $this->Campaign->Group->find('list');
		$languages = $this->Campaign->Language->find('list');
		$links = $this->Campaign->Link->find('list');
		$personalTags = $this->Campaign->PersonalTag->find('list');
		$privateMessages = $this->Campaign->PrivateMessage->find('list');
		$ratings = $this->Campaign->Rating->find('list');
		$relatedCompanies = $this->Campaign->RelatedCompany->find('list');
		$tags = $this->Campaign->Tag->find('list');
		$towns = $this->Campaign->Town->find('list');
		$users = $this->Campaign->User->find('list');
		$this->set(compact('comments', 'contents', 'files', 'flags', 'groups', 'languages', 'links', 'personalTags', 'privateMessages', 'ratings', 'relatedCompanies', 'tags', 'towns', 'users'));
		
		$this->set('campaigns',$compaign);
		$this->set('$content_class',contentWithTopAndSidebar);
	}

	//$this->set('campaign', $campaign);
}
