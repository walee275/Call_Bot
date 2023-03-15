<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bot Prject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3>Users Data</h3>
                            </div>
                            <div class="col text-end">
                                <a href="{{ route('create') }}" class="btn btn-primary">Create User</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (count($users) > 0)
                            <div class="table-resonsive">
                                <table class="table">
                                    <thead>
                                        {{-- <tr> --}}
                                        <th>S.R No.</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Audio File</th>
                                        {{-- </tr> --}}
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->age }}</td>
                                                <td class="text-center">
                                                    @if ($user->name && $user->age_audio)
                                                        <button href=""
                                                            onclick="playSound('{{ asset('audio_files/' . $user->name_audio) }}','{{ asset('audio_files/' . $user->age_audio) }}',{{ $user->id }})"
                                                            id="play-button-{{ $user->id }} "
                                                            class="btn btn-primary">Play Audio</button>
                                                        <button href="" id="stop-button-{{ $user->id }}" onclick="stopSound()"
                                                            class="btn btn-danger">Stop Audio</button>
                                                        {{-- <audio controls class="float-right " id="audio-btn">
                                                            <source
                                                                src="{{ asset('audio_files/') }}/{{ $user->name_audio }}"
                                                                type="audio/mpeg">
                                                            <source
                                                                src="{{ asset('audio_files/') }}/{{ $user->age_audio }}"
                                                                type="audio/mpeg">
                                                             <source
                                                               id="audio-1" src="{{ asset('audio_files/'. $user->name_audio) }}"
                                                                type="audio/mpeg">
                                                            <source id="audio-2" src="{{ asset('audio_files/'. $user->agee_audio) }}" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio> --}}
                                                    @else
                                                        <div class="alert alert-danger w-50">
                                                            No Audio file Found
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @else
                            <div class="alert alert-danger">No Data Found</div>

                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>




</body>
<script>
// window.onload = function(){







        var audio = new Audio();


        function playSound(path, path2, id) {
        // alert('stop-button-'+id);

        // var stopButton = document.getElementById('stop-button-'+id);
        // var playButton = document.getElementById('play-button-'+id);
        // playButton.click();
        // console.log(playButton)

        var audio1 = path;
        var audio2 = path2;

        audio.src = audio1;

            // e.preventDefault();
            // alert('hello');
            audio.play();
            audio.addEventListener("ended", function(e) {
                e.preventDefault();

                audio.src = audio2;
                audio.play();
                audio.addEventListener("ended", function(e) {
                    e.preventDefault();
                    audio.pause();
                });
            });


        // stopButton.addEventListener("click", function(e) {
        //     e.preventDefault();
        //     audio.pause();
        // });
    }

    function stopSound() {
        audio.pause();

    }
// }


    // console.log(users[0].id) ;
</script>



</html>
