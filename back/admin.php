<div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
    <p class="t cent botli"><?= $DB->title; ?></p>
    <form method="post" action="api/edit.php?do=<?= $DB->table; ?>">
        <table width="100%">
            <tbody>
                <tr class="yel">
                    <td width="40%"><?= $DB->header; ?></td>
                    <td width="40%"><?= $DB->append; ?></td>
                    <td width="10%">刪除</td>
                </tr>
                <?php
                $rows = $DB->all();
                // dd($rows);
                foreach ($rows as $row) {
                ?>
                    <tr>
                        <td>
                            <input type="text" name="acc[]" value="<?= $row['acc']; ?>">
                        </td>
                        <td>
                            <input type="password" name="pw[]" value="<?= $row['pw']; ?>">
                        </td>
                        <td>
                            <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
                            <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
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