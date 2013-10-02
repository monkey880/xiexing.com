<html>

<head>

	<style type="text/css">

		body { font-family:arial,sans-serif; font-size:9pt; }

		

		.my_clip_button { width:150px; text-align:center; border:1px solid black; background-color:#ccc; margin:10px; padding:10px; cursor:default; font-size:9pt; }

		.my_clip_button.hover { background-color:#eee; }

		.my_clip_button.active { background-color:#aaa; }

	</style>

    <script>var base_url = "<?php echo base_url();?>";</script>

	<script type="text/javascript" src="<?php echo base_url();?>public/js/ZeroClipboard.js"></script>

	<script language="JavaScript">

		var clip = null;

		

		function $(id) { return document.getElementById(id); }

		

		function init() {

			clip = new ZeroClipboard.Client();

			clip.setHandCursor( true );

			

			clip.addEventListener('mouseOver', my_mouse_over);

			clip.addEventListener('complete', my_complete);

			

			clip.glue( 'd_clip_button' );

		}

		

		function my_mouse_over(client) {

			clip.setText( $('fe_text').value );

		}

		

		function my_complete(client, text) {

			debugstr("Copied text to clipboard: " + text );

		}

		

	</script>

</head>

<body onLoad="init()">

	<table width="100%">

		<tr>

			<td width="50%" valign="top">

				<table>

					<tr>

						<td align="right"><b>js代码:</b></td>

						<td align="left"><textarea id="fe_text" cols=50 rows=5 onChange="clip.setText("<?php echo site_url(CFG_ADMINURL.'/ad/ajax_make_code/'.$ad_id) ?>")"><script src="<?php echo site_url(CFG_ADMINURL.'/ad/ajax_make_code/'.$ad_id) ?>" type="text/javascript"></script></textarea></td>

					</tr>

				</table>

				<br/>

				<div id="d_clip_button" class="my_clip_button"><b>复制代码</b></div>

			</td>

			

		</tr>

	</table>

</body>

</html>

