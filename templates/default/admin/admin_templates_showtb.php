<table>

	<tr>

		<td class="center">

			<div class="nrkk">

				<span>

					<table class="mbxg" width="100%" cellspacing="8px">

						<?php for ($i=0;$i<count($model);$i++) { ?>

						<tr>

							<td>

								<a href="javascript:void(0)" onclick="change_val('<?php echo $model[$i]['id'] ?>','<?php echo $model[$i]['filename'] ?>','<?php echo $model[$i]['remark'] ?>')"><?php echo $model[$i]['remark'] ?></a>

							</td>

							<?php $j = $i+1;$i++;  if ($j<count($model)) { ?>

							<td>

								<a href="javascript:void(0)" onclick="change_val('<?php echo $model[$j]['id'] ?>','<?php echo $model[$j]['filename'] ?>','<?php echo $model[$j]['remark'] ?>')"><?php echo $model[$j]['remark'] ?></a>

							</td>

							<?php } ?>

							<?php $j = $i+1;$i++;  if ($j<count($model)) { ?>

							<td>

								<a href="javascript:void(0)" onclick="change_val('<?php echo $model[$j]['id'] ?>','<?php echo $model[$j]['filename'] ?>','<?php echo $model[$j]['remark'] ?>')"><?php echo $model[$j]['remark'] ?></a>

							</td>

							<?php } ?>

						</tr>

						<?php } ?>

					</table>

				</span>

			</div>

		</td>

	</tr>

</table>

<script>

	function change_val(id,filename,remark){

		$("#<?php echo $uri ?>_a").html(remark);

		$("#<?php echo $uri ?>_input").val(id+'_'+filename+'_'+remark);

		TB_remove();

		}

</script>





