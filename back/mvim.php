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
                $rows = $DB->all();
                // dd($rows);
                foreach ($rows as $row) {
                    $checked = ($row['sh'] == 1) ? 'checked' : '';
                ?>
                    <tr>
                        <td width="70%"><img src="./img/<?= $row['img']; ?>" style="width:120px;height:80px;"></td>
                       
                        <td width="10%"><input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?=$checked;?>></td>
                        <td width="10%"><input type="checkbox" name="del[]" value="<?= $row['id']; ?>"></td>
                        <td>
                            <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
                            <input type="button" onclick="op(&#39;#cover&#39;,&#39;#cvr&#39;,&#39;modal/upload.php?do=<?= $DB->table; ?>&id=<?= $row['id']; ?>&#39;)" value="更換動畫">
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
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