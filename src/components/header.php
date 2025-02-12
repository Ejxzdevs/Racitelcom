<div class="h-full w-full flex flex-row bg-[#FEFEFE] rounded-md shadow-sm" >
    <div class="w-1/2 h-full" >
        <!-- Empty section -->
    </div>
    <div class="w-1/2 h-full flex flex-row gap-5 justify-end items-center text-[#716EEF]" >
        <i class="fas fa-envelope text-[20px]"></i>
        <i class="fas fa-bell text-[20px]"></i>
        <div class="flex flex-row gap-2">
            <div class="text-[10px] flex flex-col justify-end items-end text-gray-700">
                <p class="font-semibold"><?php echo $token_decoded->email ?></p>
                <p><?php echo $token_decoded->user_type ?></p>
            </div>
            <div class="flex justify-center items-center px-2">
                <a onclick="profileOption();" class="cursor-pointer">
                    <i class="fas fa-user-circle text-[#666B74] text-[25px]"></i>
                </a>
                <div id="profile" class="hidden h-[220px] w-[180px] absolute top-9 right-4 shadow-sm rounded-md bg-[#FEFEFE] font-semibold">
                    <ul>
                        <li>
                            <div class="flex flex-row items-center gap-5 ps-5 py-2 border-b border-gray-300 text-gray-500">
                                <i class="fas fa-tools"></i>
                                <a href="">Settings</a>
                            </div>
                        </li>
                        <li>
                            <form class="flex flex-row items-center gap-5 ps-5 py-2 border-b border-gray-300 text-gray-500 " action="../controller/userController.php" method="post">
                                <i class="fas fa-sign-out-alt"></i>
                                <input type="hidden" name="logout">
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function profileOption() {
        let profile = document.querySelector('#profile');
        profile.classList.toggle('hidden');
    }
</script>
