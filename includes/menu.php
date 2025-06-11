<!-- Bottom Navigation Menu -->
<div class="fixed inset-x-0 bottom-0 z-50 bg-white border-t border-gray-200 shadow-lg">
    <div class="flex justify-around items-stretch">
        <!-- Inicio -->
        <a href="index.php" class="flex flex-col items-center justify-center py-3 px-4 w-full group active:bg-gray-50 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= isActive('index.php') ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1 group-[.active]:text-blue-500 text-gray-600">Inicio</span>
        </a>

        <!-- Mis retos -->
        <a href="mis-retos.php" class="flex flex-col items-center justify-center py-3 px-4 w-full group active:bg-gray-50 transition-colors duration-200">
            <div class="relative">    
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= isActive('mis-retos.php') ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13.5713 5h7v9h-7m-6.00001-4-3 4.5m3-4.5v5m0-5h3.00001m0 0h5m-5 0v5m-3.00001 0h3.00001m-3.00001 0v5m3.00001-5v5m6-6 2.5 6m-3-6-2.5 6m-3-14.5c0 .82843-.67158 1.5-1.50001 1.5-.82843 0-1.5-.67157-1.5-1.5s.67157-1.5 1.5-1.5 1.50001.67157 1.50001 1.5Z"/>
                </svg>
                <?php if($ID_USER != 0) : ?>
                    <!-- Notificaciones de retos -->
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                <?php endif; ?>
            </div>
            <span class="text-xs mt-1 group-[.active]:text-blue-500 text-gray-600">Mis retos</span>
        </a>


        <!-- Wallet -->
        <a href="wallet.php" class="flex flex-col items-center justify-center py-3 px-4 w-full group active:bg-gray-50 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= isActive('wallet.php') ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path fill-rule="evenodd" d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z" clip-rule="evenodd"/>
            </svg>
            <span class="text-xs mt-1 group-[.active]:text-blue-500 text-gray-600">Wallet</span>
        </a>

        <!-- Perfil -->
        <a href="perfil.php" class="flex flex-col items-center justify-center py-3 px-4 w-full group active:bg-gray-50 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= isActive('perfil.php') ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs mt-1 group-[.active]:text-blue-500 text-gray-600">Perfil</span>
        </a>
    </div>
</div>