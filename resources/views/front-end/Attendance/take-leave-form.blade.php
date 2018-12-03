<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<style>
	body{
		position: relative;
		font-family: 'KHMERMEF1';
		font-size: 14px;
	}
	#btn-print{
		cursor: pointer;
        background:url({{asset('images/printer.png')}}) no-repeat center center;
        background-size: 20px;
        padding:5px 20px;
        border: 0px solid #6a6868 !important;
        border-radius: 5px 5px; 
		right:25px;
		position: absolute;
		
    }
	
	@font-face {
		font-family: 'KHMERMEF1';
		src:  url({{asset('fonts/KHMERMEF1.woff')}}) format('truetype');
	}
	@font-face {
		font-family: 'KHMERMEF2';
		src:  url({{asset('fonts/KHMERMEF2.woff')}}) format('truetype');
	}
    @font-face {
		font-family: 'KHMERMEF1';
		src:  url({{asset('fonts/KHMERMEF1.woff')}}) format('truetype');
    }
    @font-face {
		font-family: 'Kh Battambang';
		src:  url({{asset('fonts/Kh Battambang.woff')}}) format('truetype');
    }
    @page {
       size: auto;   
        margin:20px 30px 20px 30px;
        size: A4;
    }
    @media print {
        
        table{page-break-inside: avoid;}
    }
	
</style>
<div  style="max-width:960px;width:100%;margin:0 auto;">
<table width="100%" border="0" style="font-family: 'KHMERMEF1';font-size:14px;">
	<tr>
		<td align="left" colspan="3" style="font-family:'KHMERMEF1';font-size:13px">
		សូមគោរពជូន <b>
		<?php
			if($to_gender=='ប្រុស'){ echo 'លោក ';}else{echo 'លោកស្រី';}
			echo ' '.$to_name;
		?>
		</b>
		<br></td>
	</tr>
	<tr>
		<td colspan="3"><p style="text-indent: 5em;font-family:'KHMERMEF1';">
		
		<?php 
		if($to_gender=='ប្រុស'){
			echo 'ខ្ញុំបាទឈ្មោះ';
		}else{
			echo 'នាងខ្ញុំ';
		}		
		echo "<b>".(isset($name)? $name: '').'</b>'; 
		echo ' ភេទ';
		echo isset($gender)? $gender: '';
		echo 'ជា '.$position.'នៃ '.$department_name.'នៃ '.$general_department_name.' ។';
		?>
		<br><br></p>
		</td>
	</tr>
	
	<tr>
		<td align="left" width="80px" style="font-family:'KHMERMEF1';font-size:13px">កម្មវត្ថុ</td>
		<td align="left">៖ </td>
		<td align="left"​ style="font-family:'KHMERMEF1';">សំណើសុំអនុញ្ញាតច្បាប់ឈប់សម្រាកចំនួន  <?php echo isset($duration)? $duration : ''; ?> ថ្ងៃ នៅថ្ងៃទី  
			<?php 
				if(sizeof($date)>0){
					foreach ($date as $key => $value) {
						# code...
						if($key==0){
							echo $value;
						}else if($key== sizeof($date)-1){
							echo ' ថ្ងៃទី '.$value;
						}else{
							echo ' , '.$value;
						}
					}
				}
			 ?> ។
		
		</td>
	</tr>
	<tr>
		<td align="left" style="font-family:'KHMERMEF1';font-size:13px">មូលហេតុ</td>
		<td align="left">៖ </td>
		<td align="left" style="font-family:'KHMERMEF1';"><?php echo $reason; ?> </td>
	</tr>
</table>
<table width="100%" border="0" style="font-family: 'KHMERMEF1';font-size:12px;font-weight:">
	<tr>
		<td width="50%" align="center">
			<?php if(isset($url_res)){ ?>
			<a href="<?php echo isset($url_res)? $url_res: ''; ?>" style="color:#fff;text-decoration: none;font-size: 18px;">
			<div style="padding:10px 20px;background:#002060;width:250px;text-align: center;color:#fff;cursor: pointer;text-decoration: none;">អនុញ្ញាត</div></a>
			<?php }?>
		</td>
	</tr>
</table> 
</div>
</body>
</html>