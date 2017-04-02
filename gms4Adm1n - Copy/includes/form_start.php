<?php
	global $isViewAllLinked, $process, $item, $action;
?>

<!--Input form starts-->
<form action="<?php echo($action); ?>" method="post">
	<table class="inputTable" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="areaTitle" colspan="2">
			<div class="areaTitle">
				<?php 
				if($item == "Help")
				{
					echo($item);
				}
				else
				{
					echo($item . "s");
				}
				?>
			</div>
		</td>
	</tr>
	<tr>
		<td class="formTitle" colspan="2">
			<div class="formTitle">
			<!-- Single, top navigation button. -->
			<?php 
			if($item != "Help")
			{
				//Begin by showing the process, e.g., Add, Edit, or Delete.
				echo($process . " ");
				//Append an "s" -- e.g., "View all quotations."
				if ($isViewAllLinked != true)
				{
					echo($item . "s");
				}
				//Handle the grammar variations.
				else
				{
					//Make the item plural for "view all" case.
					if($process == "View all")
					{
						echo(" " . $item . "s");
					}
					//Show appropriate article before $item--e.g., "Delete a quotation."
					else
					{
						if($item=="news item") {
							echo(" a ");
						}
						elseif($item=="upcoming date") {
							echo(" an ");
						}
						else {
							echo(" a ");
						}
						echo($item);
					}
				}
			}
			?>
			</div>
		</td>
	</tr>
