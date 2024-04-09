<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Map</title>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.png">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <!-- Leaflet Routing Machine JavaScript -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <!-- awesom icons -->
    <link rel="stylesheet" href="/assets/styles/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- my css and js -->
    <link rel="stylesheet" href="assets/styles/css/map.css" />
    <script defer src="/assets/scripts/map_controll.js"></script>
    <script defer src="/assets/scripts/map.js"></script>


</head>

<body>
    <!-- MAP -->
    <button class="nav-btn open-btn">
        <i class="fa fa-bars fa-1x" aria-hidden="true"></i>
    </button>
    <section id="map-container">
        <div class="markers-container">
            <nav>
                <div class="standardMode">
                    <a href="/" class="mapNavBtn mapNavBtnSymbol">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                    <button class="mapNavBtn mapNavBtnSymbol openMapResp">
                        <i class="fa fa-map" aria-hidden="true"></i>
                    </button>
                    <select name="" id="mapCategorySelect">
                        <option value="svi">Prikazi sve</option>
                        <option value="proizvodi" class="optionProizvodi">Proizvodi</option>
                        <option value="restorani" class="optionRestorani">Restorani</option>
                        <option value="caffe" class="optionCaffe">Caffe</option>
                        <option value="suveniri" class="optionSuveniri">Suveniri</option>
                        <option value="usluge" class="optionUsluge">Usluge</option>
                        <option value="ostalo" class="optionOstalo">Ostalo</option>
                    </select>
                </div>
                <div class="focusedMode">
                    <button class="showAll mapNavBtn">Vrati nazad</button>
                    <!-- //! ovo ubaci -->
                    <!-- <button class="zoomToLocation mapNavBtn">Prikaži lokaciju</button> -->
                </div>
            </nav>

            <?php
            //showing markers
            foreach ($producers as $row) :
            ?>
                <div class="marker">
                    <div class="upperMarker">
                        <p class="markersHeadline"><?php echo $row->title; ?></p>
                        <p>
                            <?php
                            // if ($row->category == "hrana") echo "&#127828;";
                            // if ($row->category == "pica") echo "&#127870;";
                            // if ($row->category == "usluge") echo "&#128736;&#65039;";
                            ?>


                        </p>
                    </div>
                    <!-- marker rating -->
                    <div class="rateOther">
                        <input type="radio" value="5" <?php if ($row->rating >= 4.5) echo "checked"; ?> />
                        <label title="text">5 stars</label>
                        <input type="radio" value="4" <?php if ($row->rating >= 3.5 && $row->rating < 4.5) echo "checked"; ?> />
                        <label title="text">4 stars</label>
                        <input type="radio" value="3" <?php if ($row->rating >= 2.5 && $row->rating < 3.5) echo "checked"; ?> />
                        <label title="text">3 stars</label>
                        <input type="radio" value="2" <?php if ($row->rating >= 1.5 && $row->rating < 2.5) echo "checked"; ?> />
                        <label title="text">2 stars</label>
                        <input type="radio" value="1" <?php if ($row->rating > 0 && $row->rating < 1.5) echo "checked"; ?> />
                        <label title="text">1 star</label>
                    </div>

                    <p class="textMarker"><?php echo $row->body; ?></p>
                    <div class="markerContact-container">
                        <?php if ($row->contact != null) { ?>
                            <div class="contactLink">
                                <?php echo "<a href='tel:$row->contact'>$row->contact</a>"; ?>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                        <?php } ?>
                        <?php if ($row->email != null) { ?>
                            <div class="contactLink">
                                <?php echo "<a href='mailto:$row->email'>$row->email</a>"; ?>
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </div>
                        <?php } ?>
                        <?php if ($row->producerLocation != null) { ?>
                            <div class="contactLink">
                                <?php echo "<a href='$row->producerLocation'>$row->producerLocation</a>"; ?>
                                <i class="fa fa-compass" aria-hidden="true"></i>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="markerInvisablePart">
                        <?php
                        // checks if user is looged and make order or add comment 
                        if (isset($_SESSION['userRole'])) {
                            echo  "<a href='../products/order?id=" . $row->id . "' class='btnCta orderBtn'>Poruči</a>";
                        } else echo  "<button class='btnCta notLogged'>Poruči</button>";

                        ?>
                        <div class="markerComments-container">
                            <div class="markerCommentsHeadlinePart">
                                <p class="commentsHeadline">Recenzije</p>
                                <?php
                                if (isset($_SESSION['userRole'])) {
                                    echo  "<button class='btnCta addComment' onclick='openCommentSection(" . $row->id . ")'>+</button>";
                                } else echo  "<button class='btnCta notLogged'>+</button>";
                                ?>
                            </div>
                            <?php
                            //* COMMENTS
                            $commentsOfProducer = getCommentOfProducer($row->id, $comment);
                            foreach ($commentsOfProducer as $commentsRow) :
                            ?>
                                <div class="comment">
                                    <div class="commentUpperPart">
                                        <div class="commentUpperUpperPart">
                                            <p class="commentUser"><?php echo $commentsRow->username; ?></p>
                                            <p class="commentTime"><?php echo $commentsRow->timestamp; ?></p>
                                        </div>
                                        <div class="commentUpperLowerPart">
                                            <!-- comment rating -->
                                            <div class="rateOther">
                                                <input type="radio" value="5" <?php if ($commentsRow->rating == 5) echo "checked"; ?> />
                                                <label title="text">5 stars</label>
                                                <input type="radio" value="4" <?php if ($commentsRow->rating == 4) echo "checked"; ?> />
                                                <label title="text">4 stars</label>
                                                <input type="radio" value="3" <?php if ($commentsRow->rating == 3) echo "checked"; ?> />
                                                <label title="text">3 stars</label>
                                                <input type="radio" value="2" <?php if ($commentsRow->rating == 2) echo "checked"; ?> />
                                                <label title="text">2 stars</label>
                                                <input type="radio" value="1" <?php if ($commentsRow->rating == 1) echo "checked"; ?> />
                                                <label title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="commentLowerPart">
                                        <small class="commentText">
                                            <?php echo $commentsRow->comment_text; ?>
                                        </small>
                                    </div>
                                </div>

                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="markerMeta">
                        <div class="latitude"><?php echo $row->latitude; ?></div>
                        <div class="longitude"><?php echo $row->longitude; ?></div>
                        <div class="popupMsg"><?php echo $row->popupMsg; ?></div>
                        <div class="category"><?php echo $row->category; ?></div>
                        <div class="markerId data-marker-id=<?php echo $row->id; ?>"></div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
        <div class="mapBoxContainer">
            <div id="map"></div>
        </div>
    </section>

    <!-- //* COMMENT POPUP PART -->
    <section id="addComment" class="mapPopups">
        <div class="upperPart">
            <button class="btnCommentBack btnClosePopup">&#10006;</button>
            <h3>Zadovoljni uslugama?</h3>
        </div>
        <form method="POST" action="map/add-comment">
            <input type="hidden" name="marker_id" id="markerIdFieldComment" value="">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            <!-- popup comment rating -->
            <div class="rate">
                <input type="radio" id="star5" name="rate" value="5" />
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="rate" value="4" />
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="rate" value="3" />
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="rate" value="2" />
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star1" name="rate" value="1" />
                <label for="star1" title="text">1 star</label>
            </div>
            <textarea name="comment" id="commentTextArea" cols="30" rows="10" placeholder="Ovde unesite vaš komentar"></textarea>
            <button type="submit" class="btnCta">Pošaljite</button>
        </form>
    </section>
</body>

</html>