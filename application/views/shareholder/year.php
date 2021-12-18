<div align="left">
From: <input type="text" class="tcal" value="<?php $month = 7; $year = date('Y');
echo date("Y-m-t", mktime(0, 0, 0, $month - 1, 1, $year)); ?>" name="from" required>

                          To: <input type="text" class="tcal" value="<?php $month = 8; $year = date('Y');
echo date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year+1)); ?>" name="to" required>
</div>