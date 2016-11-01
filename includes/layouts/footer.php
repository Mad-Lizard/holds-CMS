<div id="footer">Copyright <?php echo date("Y"); ?>, Holds.</div>
	</body>
</html>

<?php 
//Close connection
if (isset($mysqli)) {
mysqli_close($mysqli);
}
?>