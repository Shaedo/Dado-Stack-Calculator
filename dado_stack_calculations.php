<!DOCTYPE html>
<html>
<head>
<title>Dado Calc</title>
<meta http-equiv="Content-Type" content="content/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/common.css">
</head>
<body>
<div id='intro' class='intro'>
Calculate what chippers and shims to use for a desired metric result.<br>
Max width is 21 mm (2.1cm)<br>]
</div>
<div class='form' class='form'> 
<input  type='number' id='mm_input' > 
<label id='mm_lbl' class='dynamicLabel' >Width of dado in mm:</label> 
</div>
<div> 
<input type="button" value="submit" onclick="calculate_dado_stack();" />
</div>
<div id='result' class='result'>
</div>
<script>

function calculate_dado_stack(){
	
	let a,b,c=0; // chippers of width 3.175, 2.38125, 1.5875 respectively
	let d,e,f,g=0; // shims of width 0.127, 0.254, 0.381, 0.508 respectively

	let result_message= '';

	let desired_width = document.getElementById('mm_input').value;
	let sawblade_width = 6.35; //width of L&R saw blades)
	let max_width = 21; // ~widest possible dado for table saw due to arbor 

	if(desired_width < sawblade_width){
		result_message = 'The minimum width is '+ sawblade_width + ' Try using a normal saw blade';
	}
	else{
		if(desired_width > max_width){
			let passes = Math.ceil(desired_width / max_width);
			desired_width = desired_width / passes; 
			result_message+= 'due to over-width you will need '+passes+' passes of width '+desired_width;
		}

		let remainder = desired_width - sawblade_width;

		if(remainder> 16.66875){a = 4; b = 1; c = 1;} 
		else if(remainder > 15.08125) {a = 4; b = 1; c = 0;}
		else if(remainder > 14.2875) {a = 4; b = 0; c =1;}
		else if(remainder > 13.49375) {a = 3; b = 1; c = 1;}
		else if(remainder > 12.7) {a = 4; b = 0; c = 0;}
		else if(remainder > 11.90625) {a = 3; b = 1; c = 0;}
		else if(remainder > 11.1125) {a = 3; b = 0; c = 1;}
		else if(remainder > 10.31875) {a = 2; b = 1; c = 1;}
		else if(remainder > 9.525) {a = 3; b = 0; c = 0;}
		else if(remainder > 8.73125) {a = 2; b = 1; c = 0;}
		else if(remainder > 7.9375) {a = 2; b = 0; c = 1;}
		else if(remainder > 7.14375) {a = 1; b = 1; c = 1;}
		else if(remainder > 6.35) {a = 2; b = 0; c = 0;}
		else if(remainder > 5.55625) {a = 1; b = 1; c = 0;}
		else if(remainder > 4.7625) {a = 1; b = 0; c = 1;}
		else if(remainder > 3.96875) {a = 0; b = 1; c = 1;}
		else if(remainder > 3.175) {a = 1; b = 0; c = 0;}
		else if(remainder > 2.38125) {a = 0; b = 1; c = 0;}
		else if(remainder > 1.5875) {a = 0; b = 0; c = 1;}
		else {a = 0; b = 0; c = 0;} //no chippers needed

		chipper_width=(a*3.175 + b*2.38125 + c*1.5875);

		remainder -= chipper_width;

		let max_shims = Math.ceil(remainder/0.127);
		let min_shims = Math.floor(remainder/0.127);
		
		let shim_width = min_shims*0.127;
		
		let slightly_over = max_shims*0.127 + chipper_width + sawblade_width;
		let slightly_under = shim_width + chipper_width + sawblade_width;

		switch(min_shims) {
			case 1:
			d=1; e=0; f=0; g=0;
			break;
			case 2:
			d=0; e=1; f=0; g=0;
			break;
			case 3:
			d=0; e=0; f=1; g=0;
			break;
			case 4:
			d=0; e=0; f=0; g=1;
			break;
			case 5:
			d=0; e=1; f=1; g=0;
			break;
			case 6:
			d=0; e=0; f=2; g=0;
			break;
			case 7:
			d=0; e=0; f=1; g=1;
			break;
			case 8:
			d=0; e=0; f=0; g=2;
			break;
			case 9:
			d=1; e=0; f=0; g=2;
			break;
			case 10:
			d=0; e=1; f=0; g=2;
			break;
		}

		result_message+='Just under width = '+slightly_under+'mm <br>';
		result_message+= 'Just over width (add another 0.05" shim) = '+slightly_over+'mm <br>';

		result_message+='<b>';
		result_message+='L & R saw blade <br>'
		if(a>0) result_message+= ' '+a+' x 1/8" chipper blades <br>';
		if(b>0) result_message+= ' '+b+' x 3/32" chipper blades <br>';	
		if(c>0) result_message+= ' '+c+' x 1/16" chipper blades <br>';
		if(d>0) result_message+= ' '+d+' x 0.005" shims <br>';
		if(e>0) result_message+= ' '+e+' x 0.01" shims <br>';
		if(f>0) result_message+= ' '+f+' x 0.015" shims <br>';
		if(g>0) result_message+= ' '+g+' x 0.02" shims <br>';
		result_message+='</b>';	
		result_message+='Total blade width = ' + sawblade_width + ' <br>';
		result_message+='Total Chipper width = ' + chipper_width + ' <br>';
		result_message+='Total Shim width = ' + shim_width +' <br>';
	}
	
	let result = document.getElementById('result');
	result.innerHTML = result_message;
}
</script>
</body>