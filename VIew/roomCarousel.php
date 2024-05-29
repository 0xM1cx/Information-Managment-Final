 <!-- ##### 2nd part ##### -->
 <?php
    $sql = "SELECT Pic_Name FROM rooms";
    $sql_res = mysqli_query($conn, $sql);
    ?>

 <head>
     <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
 </head>



 <div id="controls-carousel" class="relative w-full" data-carousel="static">
     <!-- Carousel wrapper -->
     <div class="relative h-56 rounded-lg md:h-96">
         <?php while ($row = mysqli_fetch_assoc($sql_res)) : ?>
             <div class="<?php echo $row['Pic_Name'] === 0 ? 'block' : 'hidden'; ?> duration-700 ease-in-out" data-carousel-item="<?php echo $row['Pic_Name'] === 0 ? 'active' : ''; ?>">
                 <img src="<?php echo $row['Pic_Name']; ?>" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Image <?php echo $row['Pic_Name'] + 1; ?>">
             </div>
         <?php endwhile; ?>
     </div>
     <!-- Slider controls -->
     <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
         <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
             <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
             </svg>
             <span class="sr-only">Previous</span>
         </span>
     </button>
     <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
         <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
             <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
             </svg>
             <span class="sr-only">Next</span>
         </span>
     </button>
 </div>

 <!-- Add Tailwind CSS and any other necessary JavaScript here -->
 <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>