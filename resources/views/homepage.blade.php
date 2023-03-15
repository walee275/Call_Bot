
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
        <div class="row text-center mt-5">
            @include('partials.alerts')

            <div class="align-items-center justify-content-center">
                <button href="" id="button" class="btn btn-primary">Register-User</button>
                <button href="" id="nxt-btn" class="btn btn-primary d-none">next</button>
                <a href="{{ route('show.users') }}" id="nxt-btn" class="btn btn-outline-primary ">Registered
                    Users</a>
                <button href="" id="rslt-btn" class="btn btn-primary d-none">results</button>
            </div>
        </div>
        <div class="card border-0">

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p class="text-danger" id="error"></p>
                        <p class="text-success" id="success"></p>
                        <form action="" class="form d-none" id="form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="label">Age</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age">
                                @error('age')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </form>
                        <div class="row">
                            <div class="col">

                            </div>
                        </div>
                        <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">

                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>

<script>
    // In your JavaScript file
    const startButton = document.querySelector('#button');
    // var playCombinedButton = document.querySelector('#audio');
    var rsltButton = document.querySelector('#rslt-btn');
    var form = document.querySelector('#form');
    var token = document.querySelector('#_token');

    var firstRecorder, secondRecorder;
    var stream;
    var firstBlob;
    var secondBlob;
    var combinedBlob;

    window.onload = function() {
        navigator.mediaDevices.getUserMedia({
            audio: true
        }).then((localStream) => {
            stream = localStream;
        });
    };

    const firstText = 'Hello!, What is your name?';
    const secondText = 'Thank you. Now please tell me what is your age?';
    var firstAns = '';
    var secondAns = '';
    var test = '';
    startButton.addEventListener('click', startSpeakFirstText);

    function startSpeakFirstText() {
        // var beepsound = new Audio(
        //     'https://www.soundjay.com/button/sounds/beep-01a.mp3');
        // beepsound.play();

        startButton.classList.add('d-none');
        const utterance = new SpeechSynthesisUtterance(firstText);
        utterance.lang = 'en-US';
        utterance.rate = 1;
        utterance.onend = startRecordingFirstInput;
        firstRecorder, secondRecorder = '';
        speechSynthesis.speak(utterance);
    }

    function startSpeakFirstText2nd() {
        // var beepsound = new Audio(
        //     'https://www.soundjay.com/button/sounds/beep-01a.mp3');
        // beepsound.play();


        const utterance = new SpeechSynthesisUtterance(
            'Sorry, Didnot understand what you said please say your name again.');
        utterance.lang = 'en-US';
        utterance.rate = 1;
        utterance.onend = startRecordingFirstInput;
        firstRecorder, secondRecorder = '';
        speechSynthesis.speak(utterance);
    }


    function startRecordingFirstInput() {
        firstAns = '';
        const recognition = new webkitSpeechRecognition();
        recognition.interimResults = true;
        recognition.lang = 'en-US';

        recognition.start();
        firstRecorder = RecordRTC(stream, {
            type: 'audio'
        });
        firstRecorder.startRecording();

        recognition.onresult = (event) => {
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    firstAns += event.results[i][0].transcript;

                    test = event.results[i].isFinal;
                    console.log(firstAns);
                } else {
                    test = event.results[i].isFinal;
                }
            }
        }

        recognition.onend = () => {
            setTimeout(() => {
                if (!test) {
                    recognition.stop();
                    firstRecorder.stopRecording();
                    startSpeakFirstText2nd();
                } else {
                    console.log('else-recog working');
                    recognition.stop();
                    firstAns = firstAns.split(" ").slice(-2);
                    console.log(firstAns[1]);

                    if (firstAns[1] == '' || firstAns[1] == undefined || firstAns[1] == null || firstAns[
                            1] ==
                        'is' || firstAns[1] == 'name') {
                        firstRecorder.stopRecording();
                        const utterance = new SpeechSynthesisUtterance(
                            'Sorry, The name provided is not correct. Tell me your name again.');
                        utterance.lang = 'en-US';
                        utterance.rate = 1;
                        utterance.onend = startRecordingFirstInput;
                        firstRecorder, secondRecorder = '';
                        speechSynthesis.speak(utterance);

                    } else {
                        if (firstRecorder) {
                            firstRecorder.stopRecording(() => {
                                firstBlob = firstRecorder.getBlob();
                                startSpeakSecondText();
                            });
                        }
                    }

                }
            }, 5000);

            console.log(firstAns);
        };
    }




    function startSpeakSecondText() {
        const utterance = new SpeechSynthesisUtterance(secondText);
        utterance.lang = 'en-US';
        speechSynthesis.speak(utterance);

        utterance.onend = () => {
            startRecordingSecondInput();
        };

    }

    function startSpeakSecondText2nd() {
        const utterance = new SpeechSynthesisUtterance('Sorry, Didnot understood please repeat your age.');
        utterance.lang = 'en-US';
        speechSynthesis.speak(utterance);

        utterance.onend = () => {
            startRecordingSecondInput();
        };

    }

    let success = document.getElementById('success');
    success.innerText = '';


    function startRecordingSecondInput() {
        const recognition = new webkitSpeechRecognition();
        recognition.interimResults = true;
        recognition.lang = 'en-US';
        secondRecorder = '';
        recognition.start();

        secondRecorder = RecordRTC(stream, {
            type: 'audio'
        });
        secondRecorder.startRecording();


        recognition.onresult = (event) => {
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    secondAns += event.results[i][0].transcript;
                    console.log(secondAns);
                    test = event.results[i].isFinal;


                } else {
                    test = event.results[i].isFinal;

                }
            }
            recognition.onend = () => {
                secondAns = secondAns.match(/\d{2}/);
                secondAns = secondAns ? parseInt(secondAns[0]) : null;
                // return console.log(Number.isInteger(secondAns));

                setTimeout(() => {

                    if (!Number.isInteger(secondAns)) {
                        recognition.stop();
                        startSpeakSecondText2nd();
                    } else {
                        recognition.stop();
                        secondRecorder.stopRecording(() => {
                            secondBlob = secondRecorder.getBlob();

                            const utterance = new SpeechSynthesisUtterance(
                                'Got it, Thank You!');
                            utterance.lang = 'en-US';
                            utterance.rate = 1;
                            speechSynthesis.speak(utterance);
                            utterance.onend = () => {
                                rsltButton.click();
                            }


                        });
                    }
                }, 4000);


            };
            const nameElement = document.querySelector('#name');
            const ageElement = document.querySelector('#age');

            // startButton.innerText = 'Re-Start';

            rsltButton.addEventListener('click', function(e) {
                e.preventDefault();

                console.log(firstAns);

                if (firstAns[0].toLowerCase() == 'is') {
                    if (firstAns[2]) {
                        if (firstAns[3]) {
                            firstAns = firstAns[1] + ' ' + firstAns[2] + ' ' + firstAns[3];
                            console.log('3 if working');

                        } else {
                            console.log('3 else working');
                            firstAns = firstAns[1] + ' ' + firstAns[2];


                        }

                    } else {
                        firstAns = firstAns[1];
                        console.log('2 else working');

                    }

                } else {
                    console.log('is not')
                }


                form.classList.remove('d-none');
                nameElement.setAttribute('value', firstAns);
                ageElement.setAttribute('value', secondAns);



            });


        }
        // Combine the audio blobs
        combinedBlob = new Blob([firstBlob, secondBlob], {
            type: 'audio/webm'
        });


        form.addEventListener('submit', function(e) {
            e.preventDefault();


            var token = document.getElementById('_token');

            var formData = new FormData();

            const name = document.getElementById('name').value;
            const age = document.getElementById('age').value;

            formData.append('_token', document.getElementById('csrf_token').value);
            formData.append('name-audio', firstBlob, 'audio.webm');
            formData.append('age-audio', secondBlob, 'audio.webm');
            formData.append('name', name);
            formData.append('age', age);
            console.log(combinedBlob);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('add.user') }}');
            xhr.send(formData);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let message = document.getElementById('error');
                        let success = document.getElementById('success');
                        console.log(xhr.response);
                        success.innerText = xhr.response;
                    } else {
                        console.error(xhr.statusText);
                    }
                }
            };
        })


        console.log('Name = ' + firstAns, 'Age = ' + secondAns);
    };
</script>

</html>
