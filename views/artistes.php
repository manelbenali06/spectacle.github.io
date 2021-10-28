<div class="container my-3">

    <h1>Artistes</h1>

    <div class="row">
        <div class="col-12">
            <?php
                $req = $db->query('SELECT * FROM artist ORDER BY id DESC');
                $artistes = $req->fetchAll();
            ?>
            <table class="table">
                <thead>
                    <tr>
                       <th>N°</th>
                        <th>Nom de l'artiste</th>
                        <th>Images</th>
                        <th>Description</th>
                         
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        foreach ($artistes as $artiste) { ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $artiste['name'] ?></td>
                                <td><?= substr($artiste['description'], 0, 200) ?></td>
                                <td><img src="assets/img/artist/<?= $artist['img'] ?>"></td>
                                
                                


                                <td><a href="index.php?page=artistes&artistes=<?= $artist['id'] ?>"><i class="fas fa-pen-square"></i></a></td>
                                <td><a href="index.php?page=artiste&artistes=<?= $artist['id'] ?>"><i class="fas fa-trash"></i></a></td>
                                <td><a href="index.php?page=artiste&artistes=<?= $artist['id'] ?>"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        <?php 
                            $i++;   
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>