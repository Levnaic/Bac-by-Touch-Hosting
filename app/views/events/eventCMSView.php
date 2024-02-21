<section id="dashBoardUpperPart" class="margins">
    <h1>Kontrolisanje Događaja</h1>
    <a href="/dashboard/events/create" id="addCalendarLinkBtn" class="margins btnAdminNav">Dodaj događaj</a>
</section>
<!-- table with users -->
<section id="usersTable" class="margins">
    <table>
        <tr>
            <th class="tableSearch">
                <form action="" method="GET">
                    <input type="text" name="searchTitle" value="<?php if (isset($_GET['searchTitle'])) {
                                                                        echo $_GET['searchTitle'];
                                                                    } ?>" placeholder="Pretraga po naslovu">
                    <button type="submit" class="filterBtn">Pretraži</button>
                </form>
            </th>
            <th class="tableSearch">
            </th>

        </tr>
        <tr>
            <th class="otherTh">Naslov Događaja</th>
            <th class="actionTh">Akcije</th>
        </tr>



        <?php
        foreach ($rows as $row) :
        ?>

            <tr>
                <td><?php echo $row->event_name; ?></td>
                <td class="usersTableBtns">
                    <div class="tableBtnsContainer">
                        <a href="/dashboard/events/update?id=<?php echo $row->id; ?>" class="adminAction firstActionBtn">Update</a>
                        <form action="/dashboard/events/delete?id=<?php echo $row->id; ?>" method="POST" id="deleteForm_<?php echo $row->id; ?>">
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