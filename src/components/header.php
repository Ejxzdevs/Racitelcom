<div class="h-full w-full flex flex-row bg-[#FEFEFE] rounded-md shadow-sm" >
    <div class="w-1/2 h-full" >
        
    </div>
    <div class="w-1/2 h-full flex flex-row gap-5 justify-end items-center text-[#716EEF]" >
        <i class="fas fa-envelope text-[20px]"></i>
        <i class="fas fa-bell text-[20px]"></i>
        <div class="flex flex-row gap-2 " >
            <div class="text-[10px] flex flex-col justify-end items-end text-gray-700" >
                <p class="font-semibold" ><?php echo $token_decoded->email ?></p>
                <p><?php echo $token_decoded->user_type ?></p>
            </div>
            <div class="flex justify-center items-center px-2" >
                <i class="fas fa-user-circle text-[#666B74] text-[25px]"></i>
            </div>
        </div>
    </div>
</div>