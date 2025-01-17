<?php
namespace App\Http\Controllers\API\V1\Core;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SearchFilters\SearchFilter as SearchFilter;

use Carbon\Carbon;

class DatamisController extends BaseController{
	
	public function __construct(){
	}
	
	
	/** owghat(month,day,longitude,latitude,Show_seconds,Daylight_Saving_Time_On,farsi_numbers) // Version:1.1 _ http://123.scr.ir */
	
	public function owghat($m ,$d ,$lg ,$lat ,$seconds=1 ,$dslst=1 ,$farsi=1){
		$a_2=array(107.695,90.833,0,90.833,94.5,0);
		$doy_1=(($m<7)?($m-1):6) + (($m-1)*30) + $d;
		for ($h=0,$i=0;$i<6;$i++){
			$s_m=$m;
			$s_lg=$lg;
			if($i<5){
				$doy=$doy_1+($h/24);
				$s_m=74.2023+(0.98560026*$doy);
				$s_l=-2.75043+(0.98564735*$doy);
				$s_lst=8.3162159+(0.065709824*floor($doy))+(24.06570984*fmod($doy,1))+($s_lg/15);
				$s_omega=(4.85131-(0.052954*$doy))*0.0174532;
				$s_ep=(23.4384717+(0.00256*cos($s_omega)))*0.0174532;
				$s_u=$s_m;
				for ($s_i=1;$s_i<5;$s_i++){
					$s_u=$s_u-(($s_u-$s_m-(0.95721*sin(0.0174532*$s_u)))/(1-(0.0167065*cos(0.0174532*$s_u))));
				}
				$s_v=2*(atan(tan(0.00872664*$s_u)*1.0168)*57.2957);
				$s_theta=($s_v-$s_m-2.75612-(0.00479*sin($s_omega))+(0.98564735*$doy))*0.0174532;
				$s_delta=asin(sin($s_ep)*sin($s_theta))*57.2957;
				$s_alpha=57.2957*atan2(cos($s_ep)*sin($s_theta),cos($s_theta));
				if($s_alpha>=360)$s_alpha-=360;
				$s_ha=$s_lst-($s_alpha/15);
				$s_zohr=fmod($h-$s_ha,24);
				$loc2hor=((acos(((cos(0.0174532*$a_2[$i])-sin(0.0174532*$s_delta)*sin(0.0174532*$lat))/cos(0.0174532*$s_delta)/cos(0.0174532*$lat)))*57.2957)/15);
				$azan[$i]=fmod((($i<2)?($s_zohr-$loc2hor):(($i>2)?$s_zohr+$loc2hor:$s_zohr)),24);
			}
			else{
				$azan[$i]=($azan[0]+$azan[3]+24)/2;
			}
			$x=$azan[$i];
			if($dslst==1 and $doy_1>1 and $doy_1<186){
				$x++;
			}
			else{
				$dslst=0;
			}
			if($x<0){
				$x+=24;
			}
			elseif($x>=24){
				$x-=24;
			}
			$hor=(int)($x);
			$ml=fmod($x,1)*60;
			$min=(int)($ml);
			$mr=round($ml);
			if($mr==60){
				$mr=0;
				$hor++;
			}
			$sec=(int)(fmod($ml,1)*60);
			$a_1[$i]=(($hor<10)?'0':'').$hor.':'.( ($seconds==0) ? ((($mr<10)?'0':'').$mr) : ((($min<10)?'0':'').$min.':'.(($sec<10)?'0':'').$sec) );
			if($h==0){
				$h=$azan[$i];
				$i--;
			}
			else{
				$h=0;
			}
		}
		$out=array(
					's'=>$a_1[0],
					't'=>$a_1[1],
					'z'=>$a_1[2],
					'g'=>$a_1[3],
					'm'=>$a_1[4],
					'n'=>$a_1[5],
					'month'=>$m,
					'day'=>$d,
					'longitude'=>$lg,
					'latitude'=>$lat,
					'show_seconds'=>$seconds,
					'daylight_saving_time'=>$dslst,
					'farsi_numbers'=>$farsi
				 );
		if($farsi==1)$out=str_replace(array('0','1','2','3','4','5','6','7','8','9','.'),array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٫'),$out);
		return $out;
	}
	public function owghatCities(){
		$city=array(
            array('آب بر','48.97','36.92'),
		    array('آباد','52.75','27.41'),
		    array('آبادان','48.28','30.33'),
		    array('آباده','52.67','31.18'),
		    array('آبدانان','47.47','32.94'),
		    array('آبکنار','49.84','37.41'),
		    array('آبیک','50.53','36.05'),
		    array('آتش خسرو','45.50','38.38'),
		    array('آتشگاه','49.88','37.27'),
		    array('آج بوزایه','49.19','37.30'),
		    array('آجه','49.80','36.80'),
		    array('آخوندمحله','49.85','37.08'),
		    array('آخوندملک','50.32','36.95'),
		    array('آذر شهر','45.97','37.76'),
		    array('آران و بیدگل','51.48','34.05'),
		    array('آزاد شهر','55.16','37.09'),
		    array('آسایشگاه باباباغی','46.50','38.00'),
		    array('آستارا','48.85','38.43'),
		    array('آستانه اشرفیه','49.98','37.27'),
		    array('آشار','61.30','26.40'),
		    array('آشتیان','50.00','34.55'),
		    array('آشخانه','56.93','37.56'),
		    array('آشوراده','54.48','36.76'),
		    array('آغاجری','47.18','37.63'),
		    array('آغل کمر','58.76','35.41'),
		    array('آق قلا','54.45','37.02'),
		    array('آقاجاری','49.83','30.70'),
		    array('آقاحسن بیگلو','48.08','39.10'),
		    array('آقچه اوبه','46.00','37.80'),
		    array('آلمالو','46.00','37.80'),
		    array('آلوچه ملک','47.22','38.06'),
		    array('آمل','52.40','36.43'),
		    array('آناخاتون','46.00','37.80'),
		    array('آهو','49.77','34.55'),
		    array('الویر','49.98','35.40'),
		    array('اباتر','49.80','37.36'),
		    array('ابراهیم سرا','50.06','37.23'),
		    array('ابهر','49.22','36.15'),
		    array('اراک','49.70','34.08'),
		    array('ارجویه','54.41','28.73'),
		    array('ارد','54.39','27.69'),
		    array('اردبیل','48.30','38.25'),
		    array('اردجان','48.83','37.54'),
		    array('اردستان','52.37','33.38'),
		    array('اردکان','54.01','32.32'),
		    array('اردل','50.66','32.00'),
		    array('ارده','49.32','37.46'),
		    array('ارزیل','46.10','38.41'),
		    array('ارسنجان','53.31','29.91'),
		    array('ارشادمحله','49.09','37.56'),
		    array('اروانه','53.29','35.54'),
		    array('اروجعلیلو','48.18','39.18'),
		    array('ارومیه','45.00','37.53'),
		    array('ازگنین سفلی','50.30','36.22'),
		    array('ازنا','48.96','33.60'),
		    array('اژدهابلوچ','49.26','37.37'),
		    array('استرقان','46.10','38.41'),
		    array('استوه','50.02','34.44'),
		    array('استهبان','54.04','29.12'),
		    array('اسدآباد','48.11','34.79'),
		    array('اسطلخ کوه','49.45','36.75'),
		    array('اسفراین','57.50','37.10'),
		    array('اسفزار','60.41','32.46'),
		    array('اسفه','48.30','38.28'),
		    array('اسکو','46.12','37.92'),
		    array('اسلام آباد','47.12','34.32'),
		    array('اسلامشهر','51.20','35.54'),
		    array('اشنویه','45.10','37.05'),
		    array('اصفهان','51.68','32.68'),
		    array('افتر','53.04','35.58'),
		    array('اقبالیه','51.54','35.30'),
		    array('اقلید','52.71','31.01'),
		    array('اکبرآباد','52.77','29.24'),
		    array('الشتر','48.25','33.87'),
		    array('الوند','49.16','36.32'),
		    array('الیگودرز','49.72','33.37'),
		    array('الینجق','46.00','37.80'),
		    array('املش','50.19','37.10'),
		    array('امیدیه','49.71','30.75'),
		    array('امیرکلا','52.71','36.62'),
		    array('اندرگان','46.10','38.41'),
		    array('اندرمان','51.78','35.53'),
		    array('اندیمشک','48.35','33.45'),
		    array('انگنه','45.17','37.53'),
		    array('اهر','47.06','38.47'),
		    array('اهرم','51.28','28.88'),
		    array('اهواز','48.72','31.28'),
		    array('ایذه','49.90','31.80'),
		    array('ایرا','48.76','38.30'),
		    array('ایرانشهر','60.70','27.20'),
		    array('ایری علیا','46.10','38.41'),
		    array('ایلام','46.43','33.63'),
		    array('ایوان','46.31','33.83'),
		    array('بابل','52.70','36.53'),
		    array('بابلسر','52.64','36.71'),
		    array('بارازلو','46.00','37.80'),
		    array('باغ ملک','49.89','31.52'),
		    array('بافت','56.60','29.28'),
		    array('بافق','55.40','31.58'),
		    array('بانه','45.92','35.98'),
		    array('بجد','59.40','32.75'),
		    array('بجنورد','57.32','37.47'),
		    array('براب','54.39','28.70'),
		    array('برازجان','51.20','29.27'),
		    array('برداسکن','57.97','35.25'),
		    array('بردسیر','56.56','29.93'),
		    array('برغان','51.73','35.84'),
		    array('برگ جهان','52.14','35.61'),
		    array('برگان','52.87','28.73'),
		    array('بروجرد','48.80','33.92'),
		    array('بروجن','51.29','31.97'),
		    array('بروغن','60.60','36.06'),
		    array('بریس','56.45','36.30'),
		    array('بزج','50.70','36.15'),
		    array('بستان آباد','46.83','37.84'),
		    array('بغ بغو','59.30','36.05'),
		    array('بقرآباد','48.25','37.78'),
		    array('بم','58.35','29.08'),
		    array('بناب','46.05','37.33'),
		    array('بندر امام خمینی','49.08','30.43'),
		    array('بندر انزلی','49.45','37.47'),
		    array('بندر ترکمن','54.07','36.88'),
		    array('بندر عباس','56.25','27.25'),
		    array('بندر گز','53.95','36.77'),
		    array('بندر گناوه','50.52','29.57'),
		    array('بندر لنگه','54.90','26.55'),
		    array('بوئین زهرا','50.06','35.77'),
		    array('بوانات','53.64','30.46'),
		    array('بوچیر','54.64','27.05'),
		    array('بوشهر','50.83','28.92'),
		    array('بوکان','46.20','36.53'),
		    array('بوکت','46.00','37.80'),
		    array('بولالو','46.00','37.80'),
		    array('بهار','48.43','34.90'),
		    array('بهبهان','50.27','30.58'),
		    array('بهجان','54.45','28.73'),
		    array('بهشهر','53.55','36.72'),
		    array('بیابانک','53.08','35.40'),
		    array('بیجار','47.60','35.87'),
		    array('بیدخت','59.50','33.28'),
		    array('بیرجند','59.22','32.88'),
		    array('بیرق','46.50','38.00'),
		    array('بیرلان','44.87','37.38'),
		    array('بیلند','58.71','34.37'),
		    array('بیله سوار','48.36','39.37'),
		    array('بیوران سفلی','45.80','36.15'),
		    array('بیورزین','55.27','37.95'),
		    array('بیهود','59.62','33.02'),
		    array('پارچین','52.50','29.10'),
		    array('پارس آباد','47.93','39.65'),
		    array('پازنویه','53.66','28.35'),
		    array('پاکدشت','51.70','35.47'),
		    array('پاوه','46.37','35.05'),
		    array('پای تاوه','54.15','27.07'),
		    array('پسیان','46.00','37.80'),
		    array('پل خواب','51.90','36.10'),
		    array('پل سفید','53.06','36.12'),
		    array('پلگی','61.80','31.12'),
		    array('پوده','51.91','32.10'),
		    array('پیر احمد کندی','45.02','38.87'),
		    array('پیرانشهر','45.13','36.70'),
		    array('پیشوا','51.73','35.30'),
		    array('تازه آباد','46.16','34.74'),
		    array('تاکستان','49.70','36.07'),
		    array('تالش','48.92','37.80'),
		    array('تایباد','60.77','34.74'),
		    array('تبریز','46.30','38.08'),
		    array('تپیک دره','46.00','37.80'),
		    array('تجرق','46.00','37.80'),
		    array('تدرویه','54.73','27.25'),
		    array('تربت جام','60.62','35.22'),
		    array('تربت حیدریه','59.22','35.28'),
		    array('تشنیز','51.29','31.26'),
		    array('تفت','54.22','31.73'),
		    array('تفرش','50.02','34.68'),
		    array('تکاب','47.10','36.41'),
		    array('تلاجیم','54.23','36.03'),
		    array('تلخک','57.07','36.16'),
		    array('تل ریگی','53.59','28.53'),
		    array('تمر','44.37','38.07'),
		    array('تنکابن','50.88','36.82'),
		    array('تورنگ تپه','54.10','37.00'),
		    array('توشمانلو','47.30','37.43'),
		    array('تولا','60.16','35.49'),
		    array('تولون','48.55','38.13'),
		    array('تویسرکان','48.44','34.55'),
		    array('تهران','51.43','35.67'),
		    array('تیزاب','54.40','28.73'),
		    array('جاجرم','56.31','36.97'),
		    array('جاسک','57.52','25.75'),
		    array('جامغان','53.58','28.53'),
		    array('جعفرآباد','50.18','33.69'),
		    array('جلفا','45.63','38.94'),
		    array('جنبذ','60.96','35.86'),
		    array('جنت آباد','50.29','34.67'),
		    array('جوانان گروه','46.10','38.41'),
		    array('جوانرود','46.52','34.80'),
		    array('جوان قلعه','46.00','37.80'),
		    array('جویبار','52.90','36.64'),
		    array('جهرم','53.55','28.50'),
		    array('جیرفت','57.73','28.67'),
		    array('چابهار','60.63','25.30'),
		    array('چاشم','53.11','35.60'),
		    array('چالدران','44.38','39.07'),
		    array('چالوس','51.41','36.66'),
		    array('چاله عالی احمدان','54.21','27.02'),
		    array('چرزه خون','46.00','37.80'),
		    array('چلگرد','50.14','32.46'),
		    array('چنار','46.42','37.80'),
		    array('چناران','59.10','36.65'),
		    array('چنشت','59.56','32.20'),
		    array('چوپانکره','46.00','37.80'),
		    array('چهاربرود','46.43','37.80'),
		    array('چهارطاق','46.00','37.80'),
		    array('چهرقان','49.19','34.50'),
		    array('حاجی آباد فارس','54.42','28.36'),
		    array('حاجی آباد هرمزگان','55.89','28.31'),
		    array('حاجی لار','46.10','38.41'),
		    array('حماملو','46.30','38.16'),
		    array('حوری','46.00','37.80'),
		    array('حوض ماهی','51.45','32.16'),
		    array('حیط','61.16','25.17'),
		    array('خاتون آباد','46.32','37.08'),
		    array('خاش','61.23','28.22'),
		    array('خانیان','46.00','37.80'),
		    array('خانیک','58.86','33.78'),
		    array('خدابنده','48.59','36.12'),
		    array('خراشاد','59.48','32.56'),
		    array('خرگرد','58.96','34.41'),
		    array('خرم آباد','48.35','33.48'),
		    array('خرمدره','49.18','36.20'),
		    array('خرمشهر','48.18','30.43'),
		    array('خرمکوه','49.87','36.74'),
		    array('خسروآباد','57.76','36.40'),
		    array('خسروی','50.80','32.07'),
		    array('خشکرود','52.58','36.64'),
		    array('خفر','52.60','33.25'),
		    array('خلخال','48.52','37.63'),
		    array('خلوص','54.41','27.10'),
		    array('خمر قلندران','54.11','27.07'),
		    array('خمین','50.05','33.63'),
		    array('خمینی شهر','51.47','32.70'),
		    array('خناوین','45.14','37.80'),
		    array('خواجه نفس','54.60','36.88'),
		    array('خواف','60.14','34.57'),
		    array('خوانسر','50.31','33.22'),
		    array('خورموج','51.37','28.66'),
		    array('خوی','44.97','38.53'),
		    array('خیاروه','44.12','39.35'),
		    array('خیبری','58.72','34.37'),
		    array('داده الوم','54.47','37.60'),
		    array('داراب','54.54','28.75'),
		    array('دارباغ','49.16','37.93'),
		    array('داربست','53.68','28.38'),
		    array('دازگاره افشار','53.35','35.70'),
		    array('دامغان','54.35','36.17'),
		    array('دانالو','46.00','37.80'),
		    array('دراز','61.71','31.30'),
		    array('درازاب','58.48','35.50'),
		    array('درفک سفلی','58.54','37.07'),
		    array('درگز','59.10','37.45'),
		    array('دره شهر','47.40','33.15'),
		    array('دزفول','48.47','32.38'),
		    array('دستجرد','51.66','32.12'),
		    array('دشتک','53.40','30.25'),
		    array('دشتی','51.37','28.65'),
		    array('دلارام','49.96','34.70'),
		    array('دلازیان','53.31','35.45'),
		    array('دلیجان','50.68','33.98'),
		    array('دماوند','52.07','35.72'),
		    array('دو گنبدان','50.78','30.36'),
		    array('دودران','48.18','39.18'),
		    array('دورود','49.05','33.49'),
		    array('دولت آباد اصفهان','51.70','32.80'),
		    array('دولوئی','58.63','34.35'),
		    array('ده دشت','50.55','30.79'),
		    array('دهبارز','57.26','27.47'),
		    array('دهتل','54.71','27.30'),
		    array('ده صوفیان','53.45','35.75'),
		    array('دهکستان','53.57','28.55'),
		    array('دهلاویه','47.90','31.03'),
		    array('دهلران','47.26','32.69'),
		    array('دیده نو','53.67','28.33'),
		    array('دیر','51.85','27.83'),
		    array('دیزج حسن بیگ','46.00','37.80'),
		    array('دیواندره','47.02','35.91'),
		    array('رازیان','46.00','37.80'),
		    array('راژان','46.23','36.57'),
		    array('رامسر','50.67','36.90'),
		    array('رامشیر','49.41','30.90'),
		    array('رامهرمز','49.62','31.27'),
		    array('رامیان','55.14','37.02'),
		    array('راور','56.81','31.27'),
		    array('رباط کریم','51.08','35.48'),
		    array('رحمانلو','46.00','37.80'),
		    array('رزجرد','52.47','30.28'),
		    array('رزن','49.03','35.38'),
		    array('رشت','49.63','37.30'),
		    array('رشتخوار','59.62','34.97'),
		    array('رضوانشهر','49.14','37.55'),
		    array('رفسنجان','56.02','30.42'),
		    array('رودبار','49.42','36.85'),
		    array('رودسر','50.30','37.13'),
		    array('روستای آسو','54.32','27.08'),
		    array('روستای زروان','53.51','27.42'),
		    array('روستای گزه','54.15','27.07'),
		    array('ری','51.43','35.59'),
		    array('ریاب','58.31','34.14'),
		    array('ریگ موری','61.69','31.23'),
		    array('زابل','61.48','31.02'),
		    array('زاغل','52.63','32.17'),
		    array('زاویه','46.00','37.80'),
		    array('زاهدان','60.83','29.50'),
		    array('زرند','56.58','30.80'),
		    array('زرین آباد زنجان','48.28','36.43'),
		    array('زرینشهر','51.59','32.45'),
		    array('زمان پوط','61.12','36.49'),
		    array('زمهریر','47.00','38.24'),
		    array('زنجان','48.50','36.67'),
		    array('زواجر','49.22','36.03'),
		    array('زیارت','45.50','33.99'),
		    array('ساری','53.10','36.55'),
		    array('ساسولی','61.84','30.99'),
		    array('ساوان','46.10','38.41'),
		    array('ساوه','50.33','35.02'),
		    array('سبزوار','57.63','36.22'),
		    array('سپیداره','45.47','36.12'),
		    array('سپیدان','52.02','30.27'),
		    array('سر پل ذهاب','45.85','34.47'),
		    array('سراب','47.57','37.95'),
		    array('سرابله','46.56','33.77'),
		    array('سراوان','62.58','27.40'),
		    array('سرباز','61.27','26.63'),
		    array('سربیشه','59.80','32.57'),
		    array('سرخس','61.17','36.54'),
		    array('سردشت','45.53','36.15'),
		    array('سروآباد','46.34','35.32'),
		    array('سقز','46.28','36.23'),
		    array('سلماس','44.75','38.18'),
		    array('سمنان','53.38','35.55'),
		    array('سمیرم','51.57','31.42'),
		    array('سنج','51.10','35.97'),
		    array('سندگان','50.80','36.20'),
		    array('سنقر','47.60','34.78'),
		    array('سنگرتپه','55.47','37.33'),
		    array('سنندج','47.02','35.30'),
		    array('سوت گوابر','50.32','36.98'),
		    array('سودکلا','52.59','36.67'),
		    array('سوسنگرد','48.17','31.55'),
		    array('سه دره','53.64','28.40'),
		    array('سهرون','46.10','38.41'),
		    array('سه کده','53.65','28.35'),
		    array('سی سخت','51.46','30.85'),
		    array('سیاوشان','50.43','34.23'),
		    array('سیاهکل','49.87','37.15'),
		    array('سیدان','60.23','32.99'),
		    array('سیرجان','55.73','29.47'),
		    array('سیمین ابرو','48.31','34.21'),
		    array('سیوان','46.10','38.41'),
		    array('شادگان','48.67','30.65'),
		    array('شازند','49.41','33.93'),
		    array('شاهرود','54.97','36.42'),
		    array('شاهین دژ','46.55','36.67'),
		    array('شاهین شهر','51.54','32.81'),
		    array('شبستر','45.70','38.18'),
		    array('شفت','49.40','37.17'),
		    array('شوش','48.24','32.19'),
		    array('شوشتر','48.83','32.05'),
		    array('شهر بابک','55.15','30.13'),
		    array('شهر کرد','50.85','32.32'),
		    array('شهرضا','51.87','32.02'),
		    array('شهریار','51.06','35.66'),
		    array('شیخ حضور','54.56','27.31'),
		    array('شیراز','52.57','29.63'),
		    array('شیروان','57.92','37.45'),
		    array('شیشوان','46.00','37.80'),
		    array('صحنه','47.69','34.48'),
		    array('صفاشهر','53.19','30.61'),
		    array('صوفی آباد','53.26','35.41'),
		    array('صومعه','46.00','37.80'),
		    array('صومعه سرا','49.32','37.28'),
		    array('طار','50.36','33.35'),
		    array('طبس','56.92','33.60'),
		    array('طرزم','46.10','38.41'),
		    array('طلائیه','48.42','30.17'),
		    array('طورآغای','51.59','33.59'),
		    array('طینوج','50.87','34.36'),
		    array('عبدیا','53.40','35.81'),
		    array('عجبشیر','45.91','37.48'),
		    array('علاء','53.41','35.53'),
		    array('فارسان','50.57','32.27'),
		    array('فاروج','58.22','37.23'),
		    array('فاضل آباد گلستان','54.75','36.90'),
		    array('فداغ','53.45','27.45'),
		    array('فرخان شاهراه','58.43','37.03'),
		    array('فرخشهر','50.98','32.27'),
		    array('فردو','50.20','36.62'),
		    array('فردوس','58.17','34.02'),
		    array('فرومد','53.43','36.06'),
		    array('فریدون کنار','52.53','36.68'),
		    array('فریدونشهر','50.12','32.93'),
		    array('فریمان','59.88','35.72'),
		    array('فسا','53.68','28.97'),
		    array('فشند','50.68','36.09'),
		    array('فشندک','50.70','36.15'),
		    array('فلاورجان','51.49','32.57'),
		    array('فولادشهر','51.38','32.43'),
		    array('فولادمحله','53.43','36.05'),
		    array('فومن','49.29','37.23'),
		    array('فیروزآباد','52.60','28.87'),
		    array('فیروزکوه','52.78','35.76'),
		    array('قائمشهر','52.87','36.47'),
		    array('قائن','59.18','33.73'),
		    array('قاسم آباد بزرگ','60.86','35.99'),
		    array('قبادبزن','50.87','34.36'),
		    array('قبادلو','46.00','37.80'),
		    array('قرچک','51.58','35.42'),
		    array('قروق','48.99','37.74'),
		    array('قروه','47.80','35.17'),
		    array('قره ضیاءالدین','45.03','38.88'),
		    array('قره بلاغ','48.59','36.12'),
		    array('قره چمن','47.58','37.48'),
		    array('قزوین','50.00','36.27'),
		    array('قشلاق حاجیلار','46.10','38.41'),
		    array('قشم','56.20','26.95'),
		    array('قصر شیرین','45.57','34.51'),
		    array('قم','50.95','34.65'),
		    array('قوچان','58.50','37.12'),
		    array('قوزلوجه','46.00','37.80'),
		    array('قوش خزاعی','58.83','36.16'),
		    array('قهدریجان','51.45','32.57'),
		    array('قیصرق','46.50','38.00'),
		    array('کازرون','51.67','29.60'),
		    array('کاشان','51.58','33.98'),
		    array('کاشانتو','51.40','34.71'),
		    array('کاشمر','58.45','35.18'),
		    array('کامیاران','46.94','34.80'),
		    array('کبودر آهنگ','48.72','35.21'),
		    array('کجور','51.74','36.39'),
		    array('کرج','50.97','35.80'),
		    array('کردکوی','54.12','36.80'),
		    array('کرمان','57.08','30.30'),
		    array('کرمانشاه','47.06','34.38'),
		    array('کلات نادری','59.77','37.00'),
		    array('کلاله','55.50','37.39'),
		    array('کلیبر','47.04','38.86'),
		    array('کلیشاد','51.55','32.54'),
		    array('کمشک','54.15','27.07'),
		    array('کنگان','52.07','27.83'),
		    array('کنگاور','47.95','34.50'),
		    array('کوته کومه','48.96','37.83'),
		    array('کوخرد','54.89','27.05'),
		    array('کودزر','49.97','34.54'),
		    array('کوراکش','46.10','38.41'),
		    array('کوشال','50.10','37.21'),
		    array('کوهدشت','47.60','33.53'),
		    array('کهلا','48.35','36.10'),
		    array('کهنوج','57.70','27.87'),
		    array('کهنه فرود','58.16','36.85'),
		    array('گاوزن محله رودبست','52.86','36.47'),
		    array('گراش','54.10','27.67'),
		    array('گرگان','54.48','36.83'),
		    array('گرمسار','52.33','35.22'),
		    array('گرمی','48.05','39.02'),
		    array('گرناویک','44.91','38.11'),
		    array('گزیر','54.56','26.74'),
		    array('گلپایگان','50.28','33.45'),
		    array('گناباد','58.68','34.35'),
		    array('گنبد قابوس','55.17','37.25'),
		    array('گیلان غرب','45.92','34.13'),
		    array('گیوی کوثر','48.35','37.69'),
		    array('لار','54.28','27.68'),
		    array('لاسجرد','52.33','35.19'),
		    array('لامرد','53.18','27.34'),
		    array('لاور جمیل','54.32','27.11'),
		    array('لاهیجان','50.00','37.20'),
		    array('لجران','48.80','36.49'),
		    array('لردگان','50.82','31.51'),
		    array('لسکه درق','48.18','39.18'),
		    array('لطیفی','53.57','27.59'),
		    array('لمزان','54.70','27.04'),
		    array('لنگرود','50.15','37.18'),
		    array('لواسان','51.78','35.82'),
		    array('ماسال','49.13','37.36'),
		    array('ماکو','44.50','39.30'),
		    array('ماه نشان','47.66','36.74'),
		    array('ماهشهر','49.22','30.65'),
		    array('مبارکه','51.66','32.49'),
		    array('محلات','50.50','33.88'),
		    array('محمدیه','51.55','35.29'),
		    array('محمودآباد','52.25','36.63'),
		    array('مراغان','45.91','36.07'),
		    array('مراغه','46.22','37.42'),
		    array('مراکان','44.43','38.42'),
		    array('مرانک','51.42','35.60'),
		    array('مرزن کلاته','53.85','36.83'),
		    array('مرقشه','45.25','38.85'),
		    array('مرند','45.77','38.43'),
		    array('مرو دشت','52.83','29.80'),
		    array('مریوان','46.20','35.45'),
		    array('مزایجان','52.99','28.81'),
		    array('مسجد سلیمان','49.30','31.98'),
		    array('مسکوتان','61.67','26.68'),
		    array('مشاهیر','46.10','38.41'),
		    array('مشکین شهر','47.68','38.38'),
		    array('مشهد','59.57','36.27'),
		    array('معدن آق دربند','57.83','35.88'),
		    array('معین آباد','50.00','34.62'),
		    array('مغدان','54.32','27.11'),
		    array('ملارد','50.99','35.67'),
		    array('ملاکلایه','50.10','36.21'),
		    array('ملایر','48.85','34.32'),
		    array('ملکان','46.53','38.07'),
		    array('مند','58.73','34.37'),
		    array('منوجان','57.50','27.41'),
		    array('موردی','53.63','27.73'),
		    array('مورود','51.10','36.00'),
		    array('مومن آباد','53.48','35.54'),
		    array('مهاباد','45.72','36.77'),
		    array('مهتابی','55.55','26.78'),
		    array('مهرآباد','46.00','37.80'),
		    array('مهران','46.17','33.12'),
		    array('مهریز','54.45','31.58'),
		    array('مهماندار','46.00','37.80'),
		    array('مهویزان','49.51','37.27'),
		    array('میاندوآب','46.10','36.97'),
		    array('میانه','47.70','37.33'),
		    array('میبد','54.01','32.23'),
		    array('میناب','57.07','27.15'),
		    array('مینودشت','55.37','37.22'),
		    array('میوه رود','46.10','38.41'),
		    array('نائین','53.08','32.87'),
		    array('ناچیت','45.41','36.16'),
		    array('نامق','60.14','35.41'),
		    array('نانسا','46.00','37.80'),
		    array('ناهارخوران','54.52','36.70'),
		    array('نبرین','46.00','37.80'),
		    array('نجف آباد','51.35','32.67'),
		    array('ندوشن','53.55','32.02'),
		    array('نشیب','58.78','36.83'),
		    array('نطنز','51.90','33.52'),
		    array('نظام آباد جدید','53.65','28.49'),
		    array('نظرآباد','50.60','35.95'),
		    array('نفت شهر','47.45','34.45'),
		    array('نقده','45.37','36.95'),
		    array('نکا','53.29','36.66'),
		    array('نمین','48.49','38.42'),
		    array('نوا','52.17','35.85'),
		    array('نور','52.03','36.63'),
		    array('نورآباد لرستان','47.97','34.08'),
		    array('نورآباد ممسنی','51.53','30.11'),
		    array('نوزاد','59.37','32.52'),
		    array('نوشهر','51.55','36.65'),
		    array('نهاوند','48.37','34.20'),
		    array('نهبندان','60.40','31.54'),
		    array('نیر اردبیل','48.00','38.03'),
		    array('نیریز','54.33','29.20'),
		    array('نیشابور','58.82','36.22'),
		    array('نیک شهر','60.22','26.23'),
		    array('وادقان','51.52','34.90'),
		    array('واریان','50.94','35.95'),
		    array('وانشان','51.58','33.32'),
		    array('ورامین','51.65','35.32'),
		    array('ورزقان','46.67','38.49'),
		    array('وسفونجرد','50.29','34.67'),
		    array('ولینجق','46.00','37.80'),
		    array('هادی شهر','45.63','38.87'),
		    array('هرات یزد','54.36','30.08'),
		    array('هرزویل','49.87','36.74'),
		    array('هرسین','47.60','34.26'),
		    array('هرگلان','46.00','37.80'),
		    array('هروان','46.00','37.80'),
		    array('هریس','47.11','38.25'),
		    array('هشترود','47.06','37.47'),
		    array('هشتگرد','50.66','35.97'),
		    array('همدان','48.58','34.77'),
		    array('هندیجان','49.72','30.24'),
		    array('هنگویه','53.62','27.06'),
		    array('هیو','51.00','36.03'),
		    array('یاسوج','51.68','30.82'),
		    array('یزد','54.37','31.92')
            );
        return array_keys($city);
        return $city;
	}
}
