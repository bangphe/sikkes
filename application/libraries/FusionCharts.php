<?php
class FusionCharts
{
function encodeDataURL($strDataURL, $addNoCacheStr=false) {	
    if ($addNoCacheStr==true) {		
		if (strpos(strDataURL,"?")<>0)
			$strDataURL .= "&FCCurrTime=" . Date("H_i_s");
		else
			$strDataURL .= "?FCCurrTime=" . Date("H_i_s");
    }
	
	return urlencode($strDataURL);
}

function datePart($mask, $dateTimeStr) {
    @list($datePt, $timePt) = explode(" ", $dateTimeStr);
    $arDatePt = explode("-", $datePt);
    $dataStr = "";
	
    if (count($arDatePt) == 3) {
        list($year, $month, $day) = $arDatePt;
		
        switch ($mask) {
        case "m": return (int)$month;
        case "d": return (int)$day;
        case "y": return (int)$year;
        }
		
        return (trim($month . "/" . $day . "/" . $year));
    }
    return $dataStr;
}

function renderChart($chartSWF, $strURL, $strXML, $chartId, $chartWidth, $chartHeight) {
	if ($strXML=="")
        $tempData = "//Set the dataURL of the chart\n\t\tchart_$chartId.setDataURL(\"$strURL\")";
    else
        $tempData = "//Provide entire XML data using dataXML method\n\t\tchart_$chartId.setDataXML(\"$strXML\")";

    $chartIdDiv = $chartId . "Div";

	$render_chart = <<<RENDERCHART
	<div id="$chartIdDiv" align="center">
		Chart.
	</div>
	<script type="text/javascript">	
		var chart_$chartId = new FusionCharts("$chartSWF", "$chartId", "$chartWidth", "$chartHeight");
		$tempData
		
		chart_$chartId.render("$chartIdDiv");
	</script>
RENDERCHART;

  return $render_chart;
}

function renderChartHTML($chartSWF, $strURL, $strXML, $chartId, $chartWidth, $chartHeight) {
    $strFlashVars = "&chartWidth=" . $chartWidth . "&chartHeight=" . $chartHeight ;
    if ($strXML=="")
        $strFlashVars .= "&dataURL=" . $strURL;
    else
        $strFlashVars .= "&dataXML=" . $strXML;

$HTML_chart = <<<HTMLCHART
	<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"  width="$chartWidth" height="$chartHeight" id="$chartId">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="$chartSWF"/>		
		<param name="FlashVars" value="$strFlashVars" />
		<param name="quality" value="high" />
		<embed src="$chartSWF" FlashVars="$strFlashVars" quality="high" width="$chartWidth" height="$chartHeight" name="$chartId" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
HTMLCHART;

  return $HTML_chart;
}

function boolToNum($bVal) {
    return (($bVal==true) ? 1 : 0);
}
}
?>
