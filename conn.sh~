# Replace connections to the database

if [ -f contact/message_connect1.php ]; then
    echo -e '\e[92m[OK]\e[0m    message_connect1.php exists.';
    mv contact/message_connect1.php contact/message_connect.php;
    echo -e '\e[92m[OK]\e[0m    message_connect1 moved.';
else
    echo -e '\e[93m[WARN]\e[0m  message_connect1 does not exist.';
fi

if [ -f php/conn/fxinstructor1.php ]; then
    echo -e '\e[92m[OK]\e[0m    fxinstructor1.php exists.';
    mv php/conn/fxinstructor1.php php/conn/fxinstructor.php;
    echo -e '\e[92m[OK]\e[0m    fxinstructor1.php moved.';
else
    echo -e '\e[93m[WARN]\e[0m  fxinstructor1.php does not exist.';
fi

if [ -f php/conn/fxpartner1.php ]; then
    echo -e '\e[92m[OK]\e[0m    fxpartner1.php exists.';
    mv php/conn/fxpartner1.php php/conn/fxpartner.php;
    echo -e '\e[92m[OK]\e[0m    fxpartner1.php moved.';
else
    echo -e '\e[93m[WARN]\e[0m  fxpartner1.php does not exist.';
fi

if [ -f php/conn/sonet1.php ]; then
    echo -e '\e[92m[OK]\e[0m    sonet1.php exists.';
    mv php/conn/sonet1.php php/conn/sonet.php;
    echo -e '\e[92m[OK]\e[0m    sonet1.php moved.';
else
    echo -e '\e[93m[WARN]\e[0m  sonet1.php does not exist.';
fi

if [ -f register/connect1.php ]; then
    echo -e '\e[92m[OK]\e[0m    connect1.php exists.';
    mv register/connect1.php register/connect.php;
    echo -e '\e[92m[OK]\e[0m    connect1.php moved.';
else
    echo -e '\e[93m[WARN]\e[0m  connect1.php does not exist.';
fi

if [ -f wallet/php/wallet_connect1.php ]; then
    echo -e '\e[92m[OK]\e[0m    wallet_connect1.php exists.';
    mv wallet/php/wallet_connect1.php wallet/php/wallet_connect.php;
    echo -e '\e[92m[OK]\e[0m    wallet_connect1.php moved.';
else
    echo -e '\e[93m[WARN]\e[0m  wallet_connect1.php does not exist.';
fi



# Make certain dirs executable

if [ -d userpgs/instructor/course_management/videos ]; then
    chmod 777 userpgs/instructor/course_management/videos;
    echo '\e[92m[OK]\e[0m    course_mng/videos made executable.';
else
    echo '\e[31m[ERR]\e[0m   course_mng/videos not found.';
fi

if [ -d userpgs/instructor/class/videos ]; then
    chmod 777 userpgs/instructor/class/videos;
    echo '\e[92m[OK]\e[0m    class/videos made executable.';
else
    echo '\e[31m[ERR]\e[0m   class/videos not found.';
fi

if [ -d userpgs/instructor/class/uploads ]; then
    chmod 777 userpgs/instructor/class/uploads;
    echo '\e[92m[OK]\e[0m    class/uploads made executable.';
else
    echo '\e[31m[ERR]\e[0m   class/uploads not found.';
fi

if [ -d userpgs/instructor/class/live/files ]; then
    chmod 777 userpgs/instructor/class/live/files;
    echo '\e[92m[OK]\e[0m    live/files made executable.';
else
    echo '\e[31m[ERR]\e[0m   live/files not found.';
fi
