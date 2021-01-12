<h1>{{ config('app.name') }}</h1>
<p>Merhaba {{ $user->fullname }}, kaydınız başarılı bir şekilde yapıldı.</p>
<p>Kaydınızı aktifleştirmek için <a href="{{ $_SERVER['HTTP_HOST'] }}/user/activate/{{ $user->activation_key }}">tıklayın</a> veya aşağıdaki bağlantıyı tarayıcınızda açın.</p>
<p>{{ $_SERVER['HTTP_HOST'] }}/user/activate/{{ $user->activation_key }}</p>
