<?php
/*
*	布局类
*
*/
class Layout{
	
	public function getLayout($val){
		//var_dump($val);
		if(is_array($val) && isset($val))
		{
			$divStr = "";
			foreach ($val as $k=>$v)
			{
				if($val[$k]!= 0)
				{
					if($k == 'img_info')
						$divStr = $this->getImginfo($v);
					if($k == 'video_info')
						$divStr .= $this->getVideoinfo($v);
					if($k == 'ats_info')
						$divStr .= $this->getAtsinfo($v);
					if($k == 'weather_info')
						$divStr .= $this->getWeatherinfo($v);
					if($k == 'info1_info')
						$divStr .= $this->getInfoinfo($v,$val['info1_txt'],1);
					if($k == 'info2_info')
						$divStr .= $this->getInfoinfo($v,$val['info2_txt'],2);
					if($k == 'info3_info')
						$divStr .= $this->getInfoinfo($v,$val['info3_txt'],3);
				}
			}
			return $divStr;
		}else
		{
			echo "layout is null";
			return false;
		}
	}

	public function getImginfo($val){
		
		$val =  explode(":",$val);
		$str="<div id='photo' class='moveDiv' style='left:$val[0]px;top:$val[1]px;width:$val[2]px;height:$val[3]px;'><img id='obj_img' src='".__ROOT__."/Public/admin/play/img01.jpg' width='100%' height='100%'/></div>";
				
		return $str;
	}
	public function getVideoinfo($val){
		//var_dump($val);
		$val =  explode(":",$val);
		$str ="<div id='video' class='moveDiv' style='left:$val[0]px;top:$val[1]px;width:$val[2]px;height:$val[3]px;z-index:50;'><video autoplay='autoplay' src='".__ROOT__."/Public/admin/play/play.mp4' width='100%' height='100%' controls preload></video></div>";
		echo $str;
		return $str;
	}
	public function getAtsinfo($val){
		//var_dump($val);
		$val =  explode(":",$val);
		$str="<div id='ats' class='moveDiv' style='left:$val[0]px;top:$val[1]px;width:$val[2]px;height:$val[3]px;background-image:url(".__ROOT__."/Public/admin/img/ats.png);'></div>";
		return $str;
	}
	public function getWeatherinfo($val){
		//var_dump($val);
		$val =  explode(":",$val);
		$str="<div id='weather' class='moveDiv' style='left:$val[0]px;top:$val[1]px;width:$val[2]px;height:$val[3]px;background-image:url(".__ROOT__."/Public/admin/img/weather.png);'></div>";
		return $str;
	}
	public function getInfoinfo($val,$txt,$s){
		//var_dump($val);
		//var_dump($txt);
		
		$val =  explode(":",$val);
		$val_txt = explode(":",$txt);
		
		$str="<div id='info_$s' class='moveDiv' style='left:$val[0]px;top:$val[1]px;width:$val[2]px;height:$val[3]px;'><marquee id='marquee' scrollamount='$val_txt[3]' direction='$val_txt[1]' style='width:100%;height:100%;' ><span style='font-size:$val_txt[2];color:$val_txt[0]' >$val_txt[4]</span></marquee></div>";
		
		return $str;
	}
	


}