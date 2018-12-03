<script type="text/javascript">
	$(document).ready(function () {
		$("#menu-1").jqxTooltip({ content: 'ព័ត៌មានផ្ទាល់ខ្លួន', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-2").jqxTooltip({ content: 'ព័ត៌មានស្ថានភាពមុខងារសាធារណៈ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-3").jqxTooltip({ content: 'ប្រវត្តិការងារ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-4").jqxTooltip({ content: 'គ្រឿងឥស្សរិយយស ប័ណ្ណសរសើរ ឬទណ្ឌកម្មវិន័យ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-5").jqxTooltip({ content: 'កំរិតវប្បធម៌ទូទៅ ការបណ្តុះបណ្តាលវិជ្ជាជីវៈ និងការបណ្តុះបណ្តាលបន្ត', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-6").jqxTooltip({ content: 'សមត្ថភាពភាសាបរទេស (មធ្យម, ល្អបង្គួរ, ល្អ, ល្អណាស់)', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-7").jqxTooltip({ content: 'ស្ថានភាពគ្រួសារ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		//$("#menu-8").jqxTooltip({ content: 'ធានាអះអាង', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#menu-9").jqxTooltip({ content: 'ចេញពីប្រព័ន្ធ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		//$("#icn-tip01").jqxTooltip({ content: 'ដាក់សំណើរដើម្បីបំពេញបែបបទ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#icn-tip02").jqxTooltip({ content: 'កែសម្រួលគណនីរបស់អ្នក', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
		$("#icn-tip03").jqxTooltip({ content: 'ដំណឹងថ្មីៗ', position: 'bottom', name: 'movieTooltip',enableBrowserBoundsDetection: true});
	});
</script>
<ul>
	<li class="item-click menu-1" id="menu-1"><a href="#personal-info">1</a></li>
	<li class="item-click menu-2" id="menu-2"><a href="#situation-public-info" >2</a></li>
    <li class="item-click menu-3" id="menu-3"><a href="#working-histroy">3</a></li>
    <li class="item-click menu-4 success" id="menu-4"><a href="#award-sanction">4</a></li>
    <li class="item-click menu-5" id="menu-5"><a href="#general-knowledge">5</a></li>
    <li class="item-click menu-6" id="menu-6"><a href="#ability-foreign-language">6</a></li>
    <li class="item-click menu-7" id="menu-7"><a href="#family-situations">7</a></li>
    <!-- <li class="item-click menu-8" id="menu-8"><a href="{{asset('background-staff-gov-info/reassured')}}" target="_blank">8</a></li> -->
    <li class="item-click menu-9" id="menu-9">
		<a href="{{asset('register/guest-logout')}}"><i class="glyphicon glyphicon-log-out item-click menu-9" data-id="9"></i> </a>
	</li>
</ul>
<style>
ul li a{
	text-decoration:none;
	color: #c7c7c7;
}
ul li a:hover{
	text-decoration:none !important;
	color: #f69b00;
	font-weight: bold;
}
</style>