<?php
App::load()->library('ImageEditor',false);
class NewsModel extends BaseModel{
	/*
	Get the news from the database
	@param $limit string The limit of news that can be selected
	@return array
	*/
	function getNews($limit=4){
		//Select the table
		$newsTable=$this->table('news');
		/*$temp=[
                        'title'=>"First Semester Exam Commences",
                        'content'=> "This is teh content",
                        'image'=> 'img/exam.jpg',
                        'time'=> $this->currentTime(),
                        'author'=> "Alagbe Israel",
                        'top'=>true
                    ];*/
		$query=$newsTable->select('*')->limit($limit);
        return self::get($query);
	}
	public function getImages($imageId){
		$newsTable=$this->table('image');
		$query=$newsTable->where('image_id',$imageId);
		$imagesObjects=$query->get();
		$images=[];
		foreach ($imagesObjects as $value) {
			$image = ImageEditor::fromString($value->data);
        	$image->resize(400, 400);
        	$image->format('jpeg');
			array_push($images,$image->base64());
		}
		return $images;
	}
	/*
	Get the news with Id greater than the given Id from the database
	@param $id Integer The id of the news
	@param $limit string The limit of news that can be selected
	@return array
	*/
	public function getNewsAfterId($id,$limit=4){
		$newsTable=$this->table('news');
		$query=$newsTable->where('id','>',$id)->limit($limit);
         return self::get($query);
	}
	/*
	Get the news with Id less than the given Id 
	@param $id Integer The id of the news
	@param $limit string The limit of news that can be selected
	@return array
	*/
	public function getNewsBeforeId($id,$limit=4){
		$newsTable=$this->table('news');
		$query=$newsTable->where('id','<',$id)->limit($limit);
         return self::get($query);
	}
	/*
	Execute the query and get the news
	@param $query  The database query
	@return array
	*/
	private function get($query){
		$raw=$query->get();
		$data=$this->formatNews($raw);
		return self::success($data);
	}
	/*
	Get the current time in miliseconds
	@return string
	*/
	private static function currentTime(){
		return number_format(microtime(true)*1000,0,'.','');
	}
	/*
	Format the news in  a form required by client
	@param $data array The data to be formated
	@return array
	*/
	private function formatNews(array $data){
		$result=[];
		foreach ($data as $key) {
			//$newsItem=(array)$key;
        	$key->time=self::currentTime();
        	unset($key->image);
        	//print_r($this->getImages($key->image_id));
        	$key->images=$this->getImages($key->image_id);
        	//$key->images=[$image->base64(),$image->base64()];
        }
		return $data;
	}
	/*
	The responce from the server
	*/
	private static function success($data){
		return [
			'success'=>true,
			'data'=>$data
		];
	}
	private static function error(){

	}
}