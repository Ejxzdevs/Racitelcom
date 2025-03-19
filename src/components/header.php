<div class="h-full w-full flex flex-row bg-[#FEFEFE] rounded-md shadow-sm cursor-pointer" >
    <div class="w-1/2 h-full" >
        <!-- Empty section -->
    </div>
    <div class="w-1/2 h-full flex flex-row gap-5 justify-end items-center text-[#141B24]" >
        <i class="fas fa-envelope text-[20px]"></i>
        <i class="fas fa-bell text-[20px]"></i>
        <div class="flex flex-row gap-2">
            <div class="text-[10px] flex flex-col justify-end items-end text-gray-700">
                <p class="font-semibold"><?php echo $token_decoded->email ?></p>
                <p><?php echo $token_decoded->user_type ?></p>
            </div>
            <div class="flex justify-center items-center px-2 ">
                <a onclick="profileOption();">
                    <i class="fas fa-user-circle text-[#141B24] text-[25px]"></i>
                </a>
                <div id="profile" class="hidden h-[220px] w-[180px] absolute top-9 right-4 shadow-lg rounded-md bg-[#FEFEFE] font-semibold border border-gray-300 ">
                    <ul>
                        <li>
                            <div class="flex flex-row items-center gap-5 ps-5 py-2 border-b border-gray-300 text-gray-700">
                                <i class="fas fa-tools"></i>
                                <a href="">Settings</a>
                            </div>
                        </li>
                        <li>
                            <form class="flex flex-row items-center gap-5 ps-5 py-2 border-b border-gray-300 text-gray-700 " action="../controller/userController.php" method="post">
                                <i class="fas fa-sign-out-alt"></i>
                                <input type="hidden" name="logout">
                                <button type="submit" class="cursor-pointer">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/header.js"></script>
