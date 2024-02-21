<section id="dashBoardUpperPart" class="margins">
    <h1>Kontrolisanje korisničkih naloga</h1>
</section>
<!-- table with users -->
<section id="usersTable" class="margins">
    <table>
        <tr>
            <th class="tableSearch">
                <form action="/dashboard/users" method="GET">
                    <input type="text" name="searchUsername" value="<?php if (isset($_GET['searchUsername'])) {
                                                                        echo $_GET['searchUsername'];
                                                                    } ?>" placeholder="Pretraga po imenu">
                    <button type="submit" class="filterBtn">Pretraži</button>
                </form>
            </th>
            <th class="tableSearch">
                <form action="" method="GET">
                    <input type="text" name="searchUserRole" value="<?php if (isset($_GET['searchUserRole'])) {
                                                                        echo $_GET['searchUserRole'];
                                                                    } ?>" placeholder="Pretraga po ulozi">
                    <button type="submit" class="filterBtn">Pretraži</button>
                </form>
            </th>
            <th class="tableSearch">

            </th>

        </tr>
        <tr>
            <th class="otherTh">Ime korisnika</th>
            <th class="otherTh">Uloga korisnika</th>
            <th class="actionTh">Akcije</th>
        </tr>



        <?php
        foreach ($rows as $row) :
        ?>

            <tr>
                <td><?php echo $row->username; ?></td>
                <td><?php echo $row->userRole; ?></td>
                <td class="usersTableBtns">
                    <div class="tableBtnsContainer">
                        <form action="/dashboard/users/delete?id=<?php echo $row->id; ?>" method="POST" id="deleteForm_<?php echo $row->id; ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" onclick="confirmDelete(<?php echo $row->id; ?>)" class="adminAction">Delete</button>
                        </form>
                    </div>
                </td>

            </tr>

        <?php endforeach ?>

    </table>
</section>

<script src="/assets/scripts/confirmator.js"></script>