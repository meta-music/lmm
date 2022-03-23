
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
<van-button type="success" @click="ttt()">成功按钮</van-button>
                    </div>

                    <div class="card-body" id="musicNotation">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import * as music21 from  "music21j"
    export default {
        data() {
            return {
                musicNotation: '',
                loaderShow: false
            }
        },
        created() {

        },
        unmounted() {

        },
        methods: {
            ttt(){
                const n1 = new music21.note.Note('C5', 0.5);
                n1.stemDirection = 'up';
                const n2 = new music21.note.Note('C5', 0.5);
                n2.stemDirection = 'up';
                const n3 = new music21.note.Note('D5');
                n3.stemDirection = 'up';
                const m = new music21.stream.Measure();
                m.renderOptions.useVexflowAutobeam = false;
                m.timeSignature = new music21.meter.TimeSignature('2/4');
                m.append(n1);
                m.append(n2);
                m.append(n3);
                m.makeBeams({inPlace: true});
                m.appendNewDOM();
            }
        }
    }
</script>

<style>

</style>
