<div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
    <p class="t cent botli"><?= $DB->title; ?></p>
    <form method="post" action="api/edit.php?do=<?= $DB->table; ?>">
        <table width="100%">
            <tbody>
                <tr class="yel">
                    <td width="70%"><?= $DB->header; ?></td>
                    <td width="10%">顯示</td>
                    <td width="10%">刪除</td>
                    <td></td>
                </tr>
                <?php
                // 共多少筆資料
                $all = $DB->math('count', '*');
                // 一頁多少個
                $div = 3;
                // 共幾頁
                $pages = ceil($all / $div);
                // 現在在第幾頁
                $now = $_GET['p'] ?? 1;
                // 每頁的起始資料序號
                $start = ($now - 1) * $div;

                // dd($rows);
                $rows = $DB->all(" limit $start,$div");
                foreach ($rows as $row) {
                    $checked = ($row['sh'] == 1) ? 'checked' : '';
                ?>
                    <tr>
                        <td width="70%"><img src="./img/<?= $row['img']; ?>" style="width:100px;height:68px;"></td>
                        <td width="10%"><input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?= $checked; ?>></td>
                        <td width="10%"><input type="checkbox" name="del[]" value="<?= $row['id']; ?>"></td>
                        <td>
                            <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
                            <input type="button" onclick="op(&#39;#cover&#39;,&#39;#cvr&#39;,&#39;modal/upload.php?do=<?= $DB->table; ?>&id=<?= $row['id']; ?>&#39;)" value="更新圖片">
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
        <div class="cent">
            <?php
            // 向左
                if(($now-1)>0){
                    $p=$now-1;
                    // 這邊為啥用大括號?
                    echo "<a href='?do={$DB->table}&p=$p'> &lt; </a>";
                }
                // 頁數
                for($i=1;$i<=$pages;$i++){
                    if($i==$now){
                        $fontsize="24px";
                    }else{
                        $fontsize="16px";
                    }
                    echo "<a href='?do={$DB->table}&p=$i' style='font-size:$fontsize'> $i </a>";
                }
                
            // 向右
            if(($now+1)<=$pages){
                $p=$now+1;
                echo "<a href='?do={$DB->table}&p=$p'> &gt; </a>";
            }
            ?>
        </div>
        <table style="margin-top:40px; width:70%;">
            <tbody>
                <tr>
                    <td width="200px"><input type="button" onclick="op(&#39;#cover&#39;,&#39;#cvr&#39;,&#39;modal/<?= $DB->table; ?>.php?table=<?= $DB->table; ?>&#39;)" value="<?= $DB->button; ?>"></td>
                    <td class="cent"><input type="submit" value="修改確定"><input type="reset" value="重置">
                    </td>
                </tr>
            </tbody>
        </table>

    </form>
</div>