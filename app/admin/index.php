<?php 
	require_once '../gally.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Insert title here</title>
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="../js/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
</head>
<body>

<div id="align">
	<input id="fileInput" name="fileInput" type="file" />
	<a href="javascript:$('#fileInput').uploadifyUpload();">Upload Files</a>
</div>

<script type="text/javascript">// <![CDATA[
	$(document).ready(function() {
		$('#fileInput').uploadify({
			'uploader'  : 'resources/uploadify/uploadify.swf',
			'script'    : 'resources/uploadify/uploadify.php',
			'cancelImg' : 'resources/uploadify/cancel.png',
			'auto'      : false,
			'multi'		: true,
			'folder'    : 'uploads'
		});
	});
// ]]></script>
</body>
</html>