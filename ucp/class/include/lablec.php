		<div class="clearer"><span></span></div>

	</div>
	<div class="footer">

			<div class="bottom">
				<table border="0" width="100%" class="lablecszoveg"><tr>

				<td width="25%" style="border: 0px">
					<span class="left" style="font-style: italic">Copyright &#169; <a href="http://<?=$config["WNev"]?>" target="_BLANK" name="lent"><?=$config["SNev"]?></a> - By Clint</span>
				</td>

				<!--<td style="text-align:center; border: 0px">
					<b style="color:white">SeeRPG</b>
				</td>-->

                <?php
					/*echo '<td width="25%" style="border: 0px">';
                    $utolso = 0;
                    $utolso_sql = mysql_query("SELECT Verzio FROM changelog ORDER BY Verzio DESC LIMIT 1");
                    if(mysql_num_rows($utolso_sql) != 0)
                    {
                        $utolso_arr = mysql_fetch_array($utolso_sql); mysql_free_result($utolso_sql);
                        $utolso = $utolso_arr["Verzio"];
                    }
					echo'<a href="changelog'.$config["Ext"].'"><span class="right" style="color: yellow;">#'.$utolso.'</span></a>';

					echo '</td>';*/
                ?>

				</tr></table>

				<div class="clearer"><span></span></div>

			</div>

	</div>

</div>

</body>

</html>
