 <!-- <div class="container"> -->
 <!-- ### Slideshow of popular rooms ### -->
 <!-- <div class="w-full">
         <h1 class="text-4xl">Popular Rooms</h1>
         <div class="flex overflow-x-scroll scrollbar-hide">
             <div class="flex-shrink-0 w-[calc(4*250px)]">
                 <?php
                    //$sql = "SELECT Room_Id, Pic_Name FROM rooms";
                    //$sql_res = mysqli_query($conn, $sql);
                    //while ($_row = mysqli_fetch_assoc($sql_res)) {
                    ?>
                     <img class="w-screen h-auto object-cover mr-4 rounded-lg shadow-md" src="./rooms pics/?php echo $_row['Pic_Name']; ?>" alt="Hotel Room <?php echo $_row['Room_Id']; ?>">
                 <?php
                    //}
                    ?>
             </div>
         </div>
     </div>
 </div> -->




 <div class="grid grid-cols-2 gap-2">
     <?php
        $sql = "SELECT Room_Id, Pic_Name FROM rooms";
        $sql_res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($sql_res)) {
        ?>
         <div>
             <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
         </div>

     <?php } ?>
 </div>