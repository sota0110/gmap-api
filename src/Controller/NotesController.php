<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 * @method \App\Model\Entity\Note[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $notes = $this->paginate($this->Notes);

        $this->set(compact('notes'));
    }

    /**
     * View method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $note = $this->Notes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('note'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $note = $this->Notes->newEmptyEntity();

        if ($this->request->is('post')) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            $this->getAddress($note);
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The note could not be saved. Please, try again.'));
        }

        
        $this->set(compact('note'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $note = $this->Notes->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            $this->getAddress($note);
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The note could not be saved. Please, try again.'));
        }
        $this->set(compact('note'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $note = $this->Notes->get($id);
        if ($this->Notes->delete($note)) {
            $this->Flash->success(__('The note has been deleted.'));
        } else {
            $this->Flash->error(__('The note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getAddress($note)
    {
        $myKey = "AIzaSyC3neA22vhHB3NjyQGBtmz35R5N3JWUEHA";
        $ur_name = urlencode($note->name);
        $url = "https://maps.googleapis.com/maps/api/geocode/json";
        $url_lat = $url . "?address=" . $ur_name . "+CA&key=" . $myKey ;
        $contents= file_get_contents($url_lat);
        $jsonData = json_decode($contents,true);
        $addresses = $jsonData["results"][0]["address_components"];
        array_shift($addresses);
        $addresses = array_reverse($addresses);
        dd(gettype($addresses[0]["long_name"]));
        $note->address = null;
        foreach($addresses as $address)
        {
            // if (0 == strcmp($value, 'ccc'))    {
            //     break;
            // }
            $note->address = $note->address . $address["long_name"] . " ";
        }
    }
}
