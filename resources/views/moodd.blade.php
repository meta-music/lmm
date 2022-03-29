<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/m21.css') }}" type="text/css" />
    <style>
        html,body{
            margin:0px;
            height:100%;
            background-color: #858585bf;
        }
        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: url("{{ asset('images/bg.png') }}")  no-repeat center 0px;
            background-size: cover;
            background-position: center 0;
            background-repeat: no-repeat;
            background-attachment: fixed;
            -webkit-background-size: cover;
            -o-background-size: cover;
            -moz-background-size: cover;
            -ms-background-size: cover;
        }
        #autobeam_goes_here {
            width: 100%;
            min-height: 100px;
            padding: 10px 10px 20px 10px;
            background-color: #f0f8ffbd;
            border-radius: 5px;
        }
        .streamHolding {
            width: 100% !important;
        }
        .streamHolding svg {
            width: 100% !important;
        }
        .input-group-append {
            background-color: #fbfdff85;
        }
        .icon-play {
            width: 38px;
            padding-top: 22px;
            float: right;
        }
        .lyrics {
            margin-top: -15px;
            margin-left: 10px;
            position: absolute;
            width: 215px;
            text-align-last: justify;
            background: url(css/bg.svg) no-repeat;
            padding-left: 30px;
            white-space:nowrap;
        }
        .melody-delete {
            width: 65px;
            float: right;
            position: absolute;
            margin: 0 0 0 -70px;
        }
    </style>
    <title>Combine meldy with lyrics Demo</title>
</head>

<body>
    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
    <a href="" class="btn btn-secondary float-left">Back</a>
<div class="text-center">
    <a href="https://meta-music.github.io/songmaker/" target="blank" class="btn btn-danger">Play</a>
    <button type="button" class="btn btn-primary" onclick="changeBgImage()">Background</button>
</div>
    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#saveModal" data-whatever="@getbootstrap">Save</button>

<div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="saveModalLabel">Save Your Song</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="song-name" class="col-form-label">Song Title:</label>
            <input type="text" class="form-control" id="song-name">
          </div>
          <div class="form-group">
            <label for="thought" class="col-form-label">Thought:</label>
            <textarea class="form-control" id="thought"></textarea>
          </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="feedback-better">
                <label class="form-check-label" for="feedback">Do you feel better now?</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="aipower">
                <label class="form-check-label" for="aipower">Improve your music by AI-powered</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="tovideo">
                <label class="form-check-label" for="tovideo">Generate your music to video</label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success">Share</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
        <div class="container d-flex justify-content-between">
        <strong class="navbar-brand d-flex align-items-center">Combine melody with lyrics Demo</strong>
        </div>
      </div>
    </header>
    <main role="main">
    <div class="container">
    <div class="row">
    <div class="col-sm-12 col-md-12 py-4">
<div class="input-group">
<!-- 今天天气晴朗, 心情愉悦 -->
  <input id="mood-text" value="A boy loves his dog" type="text" class="form-control" aria-label="Text input with dropdown button">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Melody</button>
    <div class="dropdown-menu">
      <a class="dropdown-item mood" href="javascript:moodMelody(0.9,0.9);">Happy</a>
      <a class="dropdown-item mood" href="javascript:moodMelody(0.1,0.1);">Sad</a>
      <a class="dropdown-item mood" href="javascript:moodMelody(0.9,0.1);">Peaceful</a>
      <a class="dropdown-item mood" href="javascript:moodMelody(0.1,0.9);">Upset</a>
      <div role="separator" class="dropdown-divider"></div>
      <a class="dropdown-item mimg" href="javascript:changeBgImage();">Mood Image</a>
    </div>
  </div>
</div>
    </div>
    </div>
    <script src="{{ asset('vendor/music21/music21.debug.js') }}"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <div id="autobeam_goes_here" class="d-none">
    </div>
    </div>
    </main>
    <input id="api-images" type="hidden" />
    <input id="save-images" type="hidden" />
    <script>
// TODO change the fix rules for each user based on their Characteristics
var _grades_rules = {
    "starting": {
        "0": [
            [0.5, "6"],
            [0.25, "3"],
            [0.25, "2"]
        ],
        "1": [
            [0.3, "1"],
            [0.3, "3"],
            [0.2, "5"],
            [0.1, "7"]
        ],
        "0.5": [
            [0.3, "1"],
            [0.3, "3"],
            [0.3, "4"]
        ]
    },
    "ruleset": {
        "0": {
            "1": [
                [0.5, "7"],
                [0.5, "6"]
            ],
            "2": [
                [0.3, "3"],
                [0.7, "6"]
            ],
            "3": [
                [0.5, "1"],
                [0.5, "7"]
            ],
            "4": [
                [0.5, "2"],
                [0.5, "1"]
            ],
            "5": [
                [0.5, "2"],
                [0.5, "7"]
            ],
            "6": [
                [0.5, "3"],
                [0.3, "5"],
                [0.2, "8"]
            ],
            "7": [
                [0.5, "4"],
                [0.5, "2"]
            ],
            "8": [
                [1, "3"]
            ]
        },
        "1": {
            "1": [
                [0.1, "5"],
                [0.2, "4"],
                [0.2, "6"],
                [0.3, "3"],
                [0.2, "2"]
            ],
            "2": [
                [0.7, "1"],
                [0.2, "3"],
                [0.1, "6"]
            ],
            "3": [
                [0.2, "1"],
                [0.1, "2"],
                [0.5, "5"],
                [0.2, "6"]
            ],
            "4": [
                [0.1, "3"],
                [0.5, "5"],
                [0.3, "2"],
                [0.1, "1"]
            ],
            "5": [
                [0.2, "3"],
                [0.2, "5"],
                [0.2, "6"],
                [0.3, "8"],
                [0.1, "2"]
            ],
            "6": [
                [0.5, "2"],
                [0.4, "5"],
                [0.1, "7 8"]
            ],
            "7": [
                [0.9, "8"],
                [0.1, "6"]
            ],
            "8": [
                [0.5, "6"],
                [0.1, "7"],
                [0.1, "8"],
                [0.3, "1"]
            ]
        },
        "0.5": {
            "1": null,
            "2": null,
            "3": null,
            "4": null,
            "5": null,
            "6": null,
            "7": null,
            "8": null
        }
    }
};
var _duration_rules = {
    "starting": {
        "0": [
            [0.5, "1"],
            [0.5, "0.5"]
        ],
        "1": [
            [0.6, "0.5"],
            [0.4, "1"]
        ],
        "0.5": [
            [1, "1"]
        ]
    },
    "ruleset": {
        "0": {
            "1": [
                [0.5, "0.5"],
                [0.45, "0.5 0.5"],
                [0.05, "2 0.5 0.5"]
            ],
            "2": [
                [0.5, "1"],
                [0.5, "1 1"]
            ],
            "0.5": [
                [0.5, "0.5"],
                [0.5, "1 1"]
            ]
        },
        "1": {
            "1": [
                [0.5, "1"],
                [0.4, "0.5 0.5"],
                [0.1, "2"]
            ],
            "2": [
                [0.5, "1 1"],
                [0.5, "0.5 1 0.5"]
            ],
            "0.5": [
                [0.5, "1"],
                [0.4, "0.5 1 0.5"],
                [0.1, "0.25 0.25 0.5"]
            ]
        },
        "0.5": {
            "1": [
                [0.5, "1"],
                [0.5, "0.5 0.5"]
            ],
            "0.5": [
                [0.5, "0.5 1"],
                [0.4, "1 0.5"],
                [0.1, "0.25 0.25 1"]
            ]
        }
    }
};
var MODES = ["locrian", "phrygian", "aeolian", "dorian", "mixolydian", "ionian", "lydian"];
// var ALLOWED_ROOT_NAMES = ["C", "C#", "D", "E-", "E", "F", "F#", "G", "A-", "A", "B-", "B"];
var ALLOWED_ROOT_NAMES = ["C", "C", "D", "E", "E", "F", "F", "G", "A", "A", "B", "B"];
var MODE2SHIFT = {
    "locrian": "M7",
    "phrygian": "M3",
    "aeolian": "M6",
    "dorian": "M2",
    "mixolydian": "P5",
    "ionian": "P1",
    "lydian": "P4",
};
var typeFromNumDict = {
    1.0: 'whole',
    2.0: 'half',
    4.0: 'quarter',
    8.0: 'eighth',
    16.0: '16th',
    32.0: '32nd',
    64.0: '64th',
    128.0: '128th',
    256.0: '256th',
    512.0: '512th',
    1024.0: '1024th',
    2048.0: '2048th',
    0.0: 'zero',
    0.5: 'breve',
    0.25: 'longa',
    0.125: 'maxima',
    0.0625: 'duplex-maxima',
}
var apiImages = [];

        function getApiImage(q) {
            // console.log(q);
            let moodText = $("#mood-text").val().split(' ');
            let moodKey = moodText[moodText.length-1];
            let apiUrl = '{{ route("imgApi") }}?q='+q+" "+moodKey;
            $.get(apiUrl, function(result){
                apiImages = result;
                console.log(apiUrl,apiImages);
                if (apiImages.length>0) {
                    setBgImage(apiImages[0]);
                } else {
                    let defaultUrl ='{{ route("imgApi") }}?q=love&'+(parseInt(Math.random()*10)+1);
                    $.get(defaultUrl, function(result){
                        apiImages = result;
                        setBgImage(apiImages[0]);
                        console.log(defaultUrl,apiImages);
                    });
                }
                // console.log(apiImages);
            });
        }

        function changeBgImage() {
            if (apiImages.length<1) {
                getApiImage("love");
            }
            let bgImgCss = $("body").css("background-image");
            let bgImg = bgImgCss.substring(5,bgImgCss.length-2);
            let i = apiImages.indexOf(bgImg);
            console.log(bgImg,i);
            if (-1<i<(apiImages.length-1)) {
                setBgImage(apiImages[i+1]);
            } else {
                setBgImage(apiImages[0]);
            }
        }

        function setBgImage(img) {
            if (img.length>0) {
                $('body').css("background",'url("'+img+'")  no-repeat center 0px')
                $('body').css("background-size",'cover');
            }
        }

        function select_range(low, up, ratio) {
            //"""select a integer value within `low` and `up` (included) based on `ratio`"""
            diff = up - low;
            shift = low;
            return Math.round(ratio * diff + shift);
        }

        function round_over(val, values) {
            //"""round `val` to the closest value in `values`"""
            rounded = parseFloat(Infinity)
            values.forEach(function(step) {
                if (Math.abs(val - rounded) > Math.abs(val - step)) {
                    rounded = step;
                }
            })
            return rounded;
        }

        function pick_string(rule, n) {
            low = 0;
            for (var i = 0; i < rule.length; i++) {
                chance = rule[i];
                if (n >= low && n < chance[0] + low) {
                    // console.log('pick_string_chance', chance, chance[1])
                    return chance[1]
                }
                low += chance[0];
            }
            // console.log('pick_string', rule, rule[rule.length - 1][1])
            return rule[rule.length - 1][1];
        }

        function pick_starting_symb(gram, variant) {
            var rule = gram["starting"][variant];
            pick_out = pick_string(rule, Math.random())
                // console.log('pick_starting_symb', variant, rule, pick_out)
            return pick_out;
        }

        function apply_to(gram, inp, variant) {
            out = [];
            ruleset = gram["ruleset"][variant];
            for (var i = 0; i < inp.length; i++) {
                sym = inp[i];
                rule = ruleset[sym] ? ruleset[sym] : [
                    [1, ""]
                ];
                // console.log('apply_to_rule', rule, ruleset)
                s = pick_string(rule, Math.random());
                if (s.length > 0) {
                    // console.log('apply_to_s', s, s.split(" "))
                    out = out.concat(s.split(" ")) //
                }
            }
            // console.log('apply_to', variant, inp, out)
            return out
        }

        function generate_sequence(gram, size, variant) {
            var seq, next;
            seq = [];
            next = [pick_starting_symb(gram, variant)];
            while (seq.length < size) {
                // console.log('apply_to_while', seq.length, size, seq.length < size);
                next = apply_to(gram, next, variant);
                seq = seq.concat(next);
                if ((next.length) === 0) {
                    // console.log('apply_to_break', next);
                    break;
                }
            }
            console.log('generate_sequence', seq)
            return seq.slice(0, size)
        }

        function moodMelody (valence,arousal) {
            if (valence==0.9 && arousal==0.9) {
                getApiImage('happy');
            } else if (valence==0.1 && arousal==0.1) {
                getApiImage('sad');
            } else if (valence==0.1 && arousal==0.9) {
                getApiImage('anger');
            } else {
                getApiImage('love');
            }
            $("#autobeam_goes_here").removeClass("d-none");
            var base_root = Math.floor(Math.random() * 12)

            var tempo = select_range(60, 180, arousal)
            var mode = MODES[select_range(1, MODES.length, valence) - 1]

            _base_root = new music21.pitch.Pitch(ALLOWED_ROOT_NAMES[base_root])
                // root = _base_root.transpose(MODE2SHIFT[mode])
            root = _base_root

            const m = new music21.stream.Measure();
            m.renderOptions.useVexflowAutobeam = false;
            m.timeSignature = new music21.meter.TimeSignature('4/4');

            // mot.append(music21.instrument.Piano())
            // mot.append(new music21.tempo.MetronomeMark(number = tempo))
            // mot.timeSignature = new music21.meter.TimeSignature("4/4")
            // # TODO: OSMD has issues if using self.key directly (because of the mode?)
            // pitchToSharps = new music21.key.pitchToSharps(root, mode)
            //

            var v = round_over(valence, [0, 1]) // TODO: add 0.5 when done
            var grades = generate_sequence(_grades_rules, 10, v) //# TODO: change number maybe

            var a = round_over(arousal, [0, 0.5, 1])
            var durations = generate_sequence(_duration_rules, grades.length, a)

            // motif = new music21.stream.Stream()

            for (var i = 0; i < Math.min(grades.length, durations.length); i++) {
                if (grades[i] > 0) {
                    var n = new music21.note.Note(ALLOWED_ROOT_NAMES[grades[i]], parseFloat(durations[i]));
                    console.log('~~~~~~~~~~', ALLOWED_ROOT_NAMES[grades[i]], durations[i]);
                    var keySignature = new music21.key.KeySignature(root, mode)
                    var p1 = new music21.pitch.Pitch(ALLOWED_ROOT_NAMES[grades[i]])
                    var p2 = keySignature.transposePitchFromC(p1)
                    n.pitch = p2;
                    // n.lyrics = ["dadfasfs", "sdsda"]
                    // console.log(root._step);
                    // console.log(grades);
                    // key = new music21.key.Key(root._step, mode);
                    // key.tonic.octave = select_range(2, 5, arousal);
                    // console.log(key);
                    // n.pitch = key.pitchFromDegree(grades[i]);
                    // n.octave += select_range(2, 5, arousal); // parseInt(grades[i] / 8)
                    console.log(ALLOWED_ROOT_NAMES[grades[i]] + grades[i], n.octave, n.pitch, n.pitch.name, n, mode);
                } else {
                    n = music21.note.Rest();
                }
                // n.duration = new music21.duration.Duration(typeFromNumDict[durations[i]]); //
                m.append(n);
            }
            m.makeNotation({
                inPlace: true
            });
            m.appendNewDOM($('#autobeam_goes_here'));
            let lyrics = '<p class="lyrics">'+$("#mood-text").val()+'</p>';
            let deleteBtn = '<img src="css/delete.svg" onClick="alert(\'Delete! Are you sure?\')" class="melody-delete" />';
            $(".streamHolding:last").append(lyrics + deleteBtn);
        }
        // mot.append(motif) //# mel.makeMeasures(inPlace = True)# bestClef = True
        // mot.makeNotation(inPlace = true)
        // mot.renderOptions.useVexflowAutobeam = false;
        // mot.makeBeams({
        //     inPlace: true
        // });
        // mot.appendNewDOM($('#autobeam_goes_here'));

        // s = new music21.stream.Measure();
        // s.clef = new music21.clef.TrebleClef();
        // s.renderOptions.staffLines = 5;
        // metro = new music21.tempo.Metronome();


        // const n1 = new music21.note.Note('C5', 0.5);
        // n1.stemDirection = 'up';
        // const n2 = new music21.note.Note('C5', 0.5);
        // n2.stemDirection = 'up';
        // const n3 = new music21.note.Note('D5');
        // n3.stemDirection = 'up';
        // const m = new music21.stream.Measure();
        // m.renderOptions.useVexflowAutobeam = false;
        // m.timeSignature = new music21.meter.TimeSignature('2/4');
        // m.append(n1);
        // m.append(n2);
        // m.append(n3);
        // m.makeBeams({
        //     inPlace: true
        // });
        // m.appendNewDOM($('#autobeam_goes_here'));
    </script>
</body>

</html>
