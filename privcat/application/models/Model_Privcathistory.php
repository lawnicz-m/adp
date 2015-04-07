<?php

class Model_Privcathistory extends Model {
	
	protected $columns = array(
			'privcatentry' => Model::TYPE_RELATION_SIMPLE,
			'privcat' => Model::TYPE_RELATION_SIMPLE,
			'phrase' => Model::TYPE_RELATION_SIMPLE,
			'datefrom' => Model::TYPE_NORMAL,	
			'dateto' => Model::TYPE_NORMAL,
			'link' => Model::TYPE_NORMAL,
	);
	
}