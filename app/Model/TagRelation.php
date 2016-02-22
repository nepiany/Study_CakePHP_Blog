<?php

class TagRelation extends AppModel {
	public $belongsTo = ['Post', 'tag'];
}

?>