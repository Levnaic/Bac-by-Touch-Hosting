 <!--//* BLOGS -->
 <section class="blogs margins">
   <div class="blogHeadline">
     <!-- <h1>Naši blogovi</h1> -->
   </div>
   <div class="blogCards-container">
     <?php
      foreach ($posts as $row) :
      ?>
       <div class="blogCard">
         <a href="/post?id=<?php echo $row->id; ?>">
           <div class="blog-container">
             <div class="blogImg">
               <img src="/assets/img/blog-img/<?php echo $row->img; ?>" alt="slika bloga">
             </div>
             <div class="blogTitles">
               <p class="blogTitle"><?php echo $row->title; ?></p>
               <p class="blogSubtitle"><?php echo $row->subtitle; ?></p>
             </div>
           </div>
         </a>
         <div class="blogMeta">
           <div class="blogMetaData">
             <div class="blogMetaBox">
               <small>Autor bloga:&nbsp; </small> <small> <?php echo $row->user_name ?></small>
             </div>
             <div class="blogMetaBox">
               <small>Datum pisanja bloga:&nbsp;</small> <small> <?php echo date("d", strtotime($row->created_at)) . "." . date("m", strtotime($row->created_at)) . "." . date("Y", strtotime($row->created_at)) . "."; ?></small>
             </div>
           </div>
           <div class="blogLink">
             <a href="/post?id=<?php echo $row->id; ?>">Procitaj više &#10148;</a>
           </div>
         </div>
       </div>
     <?php endforeach; ?>
   </div>
 </section>

 <script src="assets/scripts/header_footer.js"></script>