<?php

namespace app\index\model;
use think\Model;
use think\Db;
use think\Config;

/**
 * 
 */
class Product extends Model
{
	protected $table = "dn_dict";
	
	//自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }

    //自定义初始化  
    protected static function init()
    {
        //TODO:自定义的初始化
        Db::connect( Config::get("database") );
    }

    public function get_product_by_category( $category_id = 14, $offset = 0, $limit = 12 ) {
        $list = Db::query('select * from dn_product where `status` = \'A\' and category_id = :category_id order by id asc limit ' . $offset . ',' . $limit , ['category_id' => $category_id]);
        return $list ;
    }

    public function get_product_num_by_category( $category_id = 14 ) {
        $total = Db::query('select count(*) as num from dn_product where `status` = \'A\' and category_id = :category_id' , ['category_id' => $category_id]);
        return $total [0] ['num'] ;
    }
 

    public function get_product_by_id ( $id ) {
		$details = Db::query('select * from dn_product where id = :id', ['id' => $id]);
        return $details [0] ;
    }

    public function get_product( $where , $orderby, $offset, $limit ) {
        $list = Db::query('select * from dn_product where status = \'A\' order by id asc limit ' . $offset . ',' . $limit);
        return $list ;
    }

    public function get_count( $where ) {
        $num = Db::query('select count(*) num from dn_product where status = \'A\'' );
        return $num [0] ['num'] ;
    }

    public function insert_product($status, $title, $category_id, $img_url, $description) {
        return Db::query("insert into dn_product (`status`, `title`, `category_id`, `img_url`, `description`) values 
            ('{$status}', '{$title}', {$category_id}, '{$img_url}', '{$description}') ") ;
    }

    public function update_product($id , $status = null, $title = null, $category_id = null, $img_url = null, $description = null) {
        $str = "" ;
        $str .= "`status` = '" . ($status ? $status : 'A') . "'" ;
        if( $title ) $str .= ", title = '" . $title . "'" ;
        if( $category_id ) $str .= ", category_id = " . $category_id ;
        if( $img_url ) $str .= ", img_url = '" . $img_url . "'";
        if( $description ) $str .= ", description = '" . $description . "'";
        return Db::query( "update dn_product set {$str} where id = " . $id ) ; 
    }

    public function delete_product($id) {
        return Db::query( "update dn_product set `status` = 'X' where id = " . $id ) ;
    }
}