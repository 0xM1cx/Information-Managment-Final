 <!-- ##### 2nd part ##### -->
 <?php
    $sql = "SELECT Pic_Name FROM rooms";
    $sql_res = mysqli_query($conn, $sql);
    ?>


 <div id="custom-controls-gallery" class="relative w-full" data-carousel="slide">
     <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
         <?php while ($row = mysqli_fetch_assoc($sql_res)) {  ?>
             <div class="hidden duration-700 ease-in-out" data-carousel-item>
                 <img src="<?php echo $row['Pic_Name']; ?>" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
             </div>
         <?php }
            mysqli_free_result($sql_res); ?>
     </div>
     <div class="flex justify-center items-center pt-4">
         <button type="button" class="flex justify-center items-center me-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
             <span class="text-gray-400 hover:text-gray-900 dark:hover:text-white group-focus:text-gray-900 dark:group-focus:text-white">
                 <svg class="rtl:rotate-180 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                 </svg>
                 <span class="sr-only">Previous</span>
             </span>
         </button>
         <button type="button" class="flex justify-center items-center h-full cursor-pointer group focus:outline-none" data-carousel-next>
             <span class="text-gray-400 hover:text-gray-900 dark:hover:text-white group-focus:text-gray-900 dark:group-focus:text-white">
                 <svg class="rtl:rotate-180 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                 </svg>
                 <span class="sr-only">Next</span>
             </span>
         </button>
     </div>
 </div>