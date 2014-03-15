/*!
 * Quized jQuery Plugin
 * http://github.com/drmartin/quized
 *
 *
 * @author Daniel Reyes - http://www.drmart.in
 * @copyright (c) 2013 Pliskin - http://www.plisk.in
 * @license MIT
 */

(function($){

    $.quized = function(element, options) {
        var $element = $(element),
             element = element;

        var plugin = this;

        var defaults = {
            checkAnswerText:  'Verifica mi respuesta',
            nextQuestionText: 'Siguiente &raquo;',
            trackMessage: false,
            backButtonText: '',
            randomSort: false,
            randomSortQuestions: false,
            randomSortAnswers: false,
            preventUnanswered: false,
            completionResponseMessaging: false,
            disableResponseMessaging: false
        };

        //-- Reassign user-submitted deprecated options
        var depMsg = '';

        // //-- 
        // if (options && typeof options.disableNext != 'undefined') {
        //     if (typeof options.preventUnanswered == 'undefined') {
        //         options.preventUnanswered = options.disableNext;
        //     }
        //     depMsg += 'La opción \'disableNext\' ha sido deprecada, por favor usa \'preventUnanswered\' en su lugar.\n\n';
        // }

        if (depMsg != '') {
            if (typeof console != 'undefined') {
                console.warn(depMsg);
            } else {
                alert(depMsg);
            }
        }
        //-- End of deprecation reassignment

        //--
        plugin.config = $.extend(defaults, options);

        //-- 
        var selector = $(element).attr('id');

        //-- 
        var triggers = {
            starter:         '#' + selector + ' .iniQuiz',
            checker:         '#' + selector + ' .checkAnswer',
            next:            '#' + selector + ' .nextQuestion',
            back:            '#' + selector + ' .backToQuestion'
        }

        //--
        var targets = {
            quizName:        '#' + selector + ' .quizName',
            quizArea:        '#' + selector + ' .quizArea',
            quizQuestions:   '#' + selector + ' .questions',
            quizResults:     '#' + selector + ' .quizResults',
            quizResultsCopy: '#' + selector + ' .quizResultsCopy',
            quizScore:       '#' + selector + ' .quizScore',
            quizLevel:       '#' + selector + ' .quizLevel'
        }

        //-- Set via json option or quizJSON variable (see quized-config.js)
        var quizValues = (plugin.config.json ? plugin.config.json : typeof quizJSON != 'undefined' ? quizJSON : null);

        //--
        var questions = (plugin.config.randomSort || plugin.config.randomSortQuestions)
                        ?
                        quizValues.questions.sort(function() { return (Math.round(Math.random())-0.5);})
                        :
                        quizValues.questions;

        //console.dir(questions);

        //-- 
        var levels = {
            1: quizValues.info.level1, // 080-100%
            2: quizValues.info.level2, // 060-079%
            3: quizValues.info.level3, // 040-059%
            4: quizValues.info.level4, // 020-039%
            5: quizValues.info.level5  // 000-019%
        }

        //-- Count the number of questions
        var questionCount = questions.length;

        //--
        plugin.method = {

            //-- Avanzar
            avanzar: function() {
                console.log('Mostrar valor agregado en esta llamada lalalalala');
                return false;
            },

            //-- Sets up the questions and answers based on above array
            setupQuiz: function() {
                //-- 
                $(targets.quizName).hide().html(quizValues.info.name).fadeIn(1000);

                //--
                $(targets.quizResultsCopy).append(quizValues.info.results);

                //-- Appends check answer / back / next question buttons
                if (plugin.config.trackMessage == true) {
                    var res     = $('<div class="trackMessage"></div>')
                    var res_NO  = $('<div><label class="res_SI_label">0</label><span class="res_SI">0</span></div>');
                    var res_SI  = $('<div><label class="res_NO_label">0</label><span class="res_NO">0</span></div>');
                    res.append(res_NO).append(res_SI);
                    $(targets.quizResults).append(res);
                }

                //-- Setup questions
                var quiz  = $('<ol class="questions"></ol>'),
                    count = 1;

                //-- Loop through questions object
                for (i in questions) {
                    if (questions.hasOwnProperty(i) && count<quizCOUNT ) {

                        var question = questions[i];
                        var cab = '';

                        //console.log(" -> Q: "+(count));
                        //console.dir(question);

                        //cab += '<h3 class=\'pregunta_texto\'>' + count + '. ' + question.q + '</h3>';
                        cab += '<h3 class=\'pregunta_texto\'>' + question.q + '</h3>';
                        //cab   +=  '<h3>';
                        //cab   +=      '<img src="/web/bundles/hppsismografo/images/style-960/quiz/Q'+(count)+'.png" />';
                        //cab   +=  '</h3>';

                        var questionHTML = $('<li class="question" id="question' + (count - 1) + '"></li>');
                        questionHTML.append('<div class="questionCount">Pregunta <span class="current">' + count + '</span> de <span class="total">' + questionCount + '</span></div>');
                        questionHTML.append(cab);

                        //-- Count the number of true values
                        var res_positive = 0;
                        for (i in question.a) {
                            if (question.a.hasOwnProperty(i)) {
                                var answer = question.a[i];
                                if (answer.correct) {
                                    res_positive++;
                                }
                            }
                        };

                        //-- prepare a name for the answer inputs based on the question
                        var inputName  = 'question' + (count - 1);

                        //-- Now let's append the answers with checkboxes or radios depending on truth count
                        var answerHTML = $('<ul class="answers"></ul>');

                        //--
                        var answers = plugin.config.randomSort || plugin.config.randomSortAnswers
                            ?
                            question.a.sort(function() { return (Math.round(Math.random())-0.5); })
                            :
                            question.a;

                        //--
                        for (i in answers) {
                            if (answers.hasOwnProperty(i)) {
                                var answer   = answers[i],
                                    answerCAT = 0,
                                    optionId = inputName + '_' + i.toString();

                                    answerCAT = parseInt((answer.categoria).replace(/(PTJ_)/, ''));
                                    //console.dir(answer);

                                //-- If question has >1 true answers, use checkboxes; otherwise, radios
                                var input = '<input id="' + optionId + '" name="' + inputName + '" type="' + (res_positive > 1 ? 'checkbox' : 'radio') + '" />';

                                var optionLabel = '<label for="' + optionId + '">' + answer.option + '</label>';

                                var answerContent = $('<li></li>')
                                //var answerContent = $('<li></li>').attr('data-puntos', answerCAT)
                                    .append(input)
                                    .append(optionLabel);
                                answerHTML.append(answerContent);
                            }
                        };

                        //-- Append answers to question
                        questionHTML.append(answerHTML);

                        //-- If response messaging is NOT disabled, add it
                        if (!plugin.config.disableResponseMessaging) {
                            //-- Now let's append the correct / incorrect response messages
                            var responseHTML = $('<ul class="responses"></ul>');
                            responseHTML.append('<li class="correct">' + question.correct + '</li>');
                            responseHTML.append('<li class="incorrect">' + question.incorrect + '</li>');

                            //-- Append responses to question
                            questionHTML.append(responseHTML);
                        }

                        //-- Appends check answer / back / next question buttons
                        if (plugin.config.backButtonText && plugin.config.backButtonText != '') {
                            questionHTML.append('<a href="" class="button backToQuestion">' + plugin.config.backButtonText + '</a>');
                        }

                        //-- If response messaging is disabled or hidden until the quiz is completed, make the nextQuestion button the checkAnswer button, as well
                        if (plugin.config.disableResponseMessaging || plugin.config.completionResponseMessaging) {
                            questionHTML.append('<a href="" class="button nextQuestion checkAnswer" data-estatus="no_activo">' + plugin.config.nextQuestionText + '</a>');
                        } else {
                            questionHTML.append('<a href="" class="button nextQuestion" data-estatus="no_activo">' + plugin.config.nextQuestionText + '</a>');
                            questionHTML.append('<a href="" class="button checkAnswer">' + plugin.config.checkAnswerText + '</a>');
                        }

                        //-- Append question & answers to quiz
                        quiz.append(questionHTML);

                        //-- Contador
                        count++;
                    };
                };

                //-- Add the quiz content to the page
                $(targets.quizArea).append(quiz);

                //-- Toggle the start button
                $(triggers.starter).fadeIn(500);
            },

            //-- Starts the quiz (hides start button and displays first question)
            iniQuiz: function(startButton) {
                $(startButton).fadeOut(300, function(){

                    //-- Toggle the start button

                    var firstQuestion = $('#' + selector + ' .questions li').first();

                    //--
                    $(targets.quizQuestions+' question.li').removeClass('activo');
                    firstQuestion.addClass('activo');

                    //--
                    if (firstQuestion.length) {
                        firstQuestion.fadeIn(500);
                    }

//                  var firstQuestion = $('#' + selector + ' .questions li').first();
//                  if (firstQuestion.length) {
//                      firstQuestion.fadeIn(500);
//                  }
                });
            },

            //-- Validates the response selection(s), displays explanations & next question button
            checkAnswer: function(checkButton) {
                //--
                $(checkButton).parent().parent();
                //-- Data SELECCI?N Quiz
                var
                //questionLI        = $($(checkButton).parent('li.question')[0]), //-- PREGUNTA ID
                questionLI      = $(checkButton).parent(), //-- PREGUNTA ID
                answerInputs    = questionLI.find('.answers input:checked'), //-- RESPUESAS
                answerSEL       = '', //-- RESPUESTA SELECCIONADA
                answerCAT       = '', //-- RESPUESTAS CATEGORIA
                answerPOSITIVO  = '', //-- RESPUESTAS CATEGORIA

                //-- Data CORRECTAS Quiz
                questionJSN     = questions[parseInt(questionLI.attr('id').replace(/(question)/, ''))].q, //-- PREGUNTA ID
                answers         = questions[parseInt(questionLI.attr('id').replace(/(question)/, ''))].a; //-- RESPUESTAS

                //console.log('CLIC que?');
                //console.info("-> LID: "+$(checkButton).parents('li.question')[0]);
                //console.log("-> CHK: "+$(checkButton).text());
                //--
                ////console.info("-> LIQ: "+questionLI.attr('id'));
                //--
                //console.log('PREGUNTAS: ');
                //console.dir(questions);

                //-- Collect the answers submitted
                var selectedAnswers = []
                answerInputs.each( function() {
                    // If we're in jQuery Mobile, grab value from nested span
                    if ($('.ui-mobile').length > 0) {
                        var inputValue = $(this).next('label').find('span.ui-btn-text').html();
                    } else {
                        //var inputValue = $(this).next('label').html();
                        var inputValue = $(this).next('label').find('span.etiqueta').html();
                    }

                    //-- Selecci?n. ?ltima que se seleccion?. Variable
                    answerSEL = inputValue;

                    //-- Selecci?n. ?ltima que se seleccion?. Agrega la respuesta a las seleccionadas
                    selectedAnswers.push(inputValue);

                    //console.log('-> INP: '+inputValue);
                });

                //-- Collect the true answers needed for a correct response
                var trueAnswers = [];

                //--
                //console.log('RESPUESTAS SELECCIONADAS: ');
                //console.dir(answers);

                //--
                for (i in answers) {
                    if (answers.hasOwnProperty(i)) {
                        var answer = answers[i];

                        if (answer.correct) {
                            trueAnswers.push(answer.option);
                        }

                        //--
                        //console.log(""+answerSEL+" == "+answer.id+" : "+(answerSEL == answer.id));

                        //-- Correcta. Variable
                        //if(answerSEL == answer.option){
                        if(answerSEL == answer.id){
                            answerCAT = answer.categoria;
                            answerPOSITIVO = answer.positivo;
                        }
                        //answer.categoria
                    }
                }

                //--
                answerCAT = parseInt(answerCAT.replace(/(PTJ_)/, ''));

                //--
                //console.info('PREGUNTA');
                //--
                //console.log('P SEL: '+questionJSN);
                //console.log('A SEL: '+answerSEL);
                //console.log('A PTJ: '+answerCAT);
                //console.log('A CFG: '+plugin.config.preventUnanswered);
                //console.log('T TOT: '+selectedAnswers.length);

                //--
                if (plugin.config.preventUnanswered && selectedAnswers.length == 0) {
                    alert('Debes seleccionar al menos una respuesta.');
                    return false;
                }

                //-- Verify all true answers (and no false ones) were submitted
                var correctResponse = plugin.method.compareAnswers(trueAnswers, selectedAnswers);

                //questionLI.addClass('NIV_'+answerCAT);
                questionLI.addClass('NIV_'+answerCAT);
                questionLI.addClass( ( answerPOSITIVO ? 'positivo' : 'negativo' ) );
                questionLI.attr('data-puntos', answerCAT);

                if (correctResponse) {
                    questionLI.addClass('correctResponse');
                }

                //-- If response messaging hasn't been disabled, toggle the proper response
                if (!plugin.config.disableResponseMessaging) {
                    //-- If response messaging hasn't been set to display upon quiz completion, show it now
                    if (!plugin.config.completionResponseMessaging) {
                        questionLI.find('.answers').hide();
                        questionLI.find('.responses').show();

                        $(checkButton).hide();
                        questionLI.find('.nextQuestion').fadeIn(300);
                        questionLI.find('.backToQuestion').fadeIn(300);
                    }

                    //-- Toggle responses based on submission
                    if (correctResponse) {
                        questionLI.find('.correct').fadeIn(300);
                    } else {
                        questionLI.find('.incorrect').fadeIn(300);
                    }
                }
            },

            //-- Moves to the next question OR completes the quiz if on last question
            nextQuestion: function(nextButton) {
                var
                currentQuestion = $($(nextButton).parents('li.question')[0]),
                nextQuestion    = currentQuestion.next('.question'),
                answerInputs    = currentQuestion.find('input:checked');

                $(targets.quizQuestions+' li.question').removeClass('activo');
                nextQuestion.addClass('activo');

                // If response messaging has been disabled or moved to completion,
                // make sure we have an answer if we require it, let checkAnswer handle the alert messaging
                if (plugin.config.preventUnanswered && answerInputs.length == 0) {
                    return false;
                }

                if (nextQuestion.length) {
                    currentQuestion.fadeOut(300, function(){
                        nextQuestion.find('.backToQuestion').show().end().fadeIn(500, function(){

                            //--
                            var
                            score     = $('#' + selector + ' .correctResponse').length,
                            levelRank = plugin.method.calculateLevel(score),
                            levelText = levels[levelRank],
                            ptj_arr = new Array(),
                            ptj_str = "",
                            niv_res = 'NIV_1',
                            niv_res_val = '1';
                            //--
                            var ptj_tot_positivo = 0;
                            var ptj_tot_negativo = 0;
                            //--
                            //console.info('PUNTAJES');

                            //--  POSITIVOS
                            $(targets.quizQuestions+' li.question.positivo').each(function(idx, ele){
                                var ptj = $(ele).attr('data-puntos');
                                //--
                                ptj = isNumeric(ptj) ? parseInt(ptj) : 0;
                                //ptj = parseInt(ptj);
                                //--
                                //console.log('->ptj itm I: '+ptj);
                                //--
                                ptj_tot_positivo += ptj;
                            });
                            //-- RECUENTO
                            //console.log("-> TOT "+ptj_tot_positivo);
                            //-- Pad 0 left
                            ptj_str = "";
                            ptj_str = pad(ptj_tot_positivo, 4, 0);
                            //console.log("-> TOT POS "+ptj_str);
                            //--
                            ptj_arr = new Array();
                            ptj_arr = ptj_str.split("");
                            //console.dir(ptj_arr);

                            //--
                            $(".res_SI").html(ptj_tot_positivo);

                            // //--
                            // $(".res_SI").jCountdown("funcionX", {
                            //  a: (isNumeric(ptj_arr[0]) ? parseInt(ptj_arr[0]) : 0),
                            //  b: (isNumeric(ptj_arr[1]) ? parseInt(ptj_arr[1]) : 0),
                            //  c: (isNumeric(ptj_arr[2]) ? parseInt(ptj_arr[2]) : 0),
                            //  d: (isNumeric(ptj_arr[3]) ? parseInt(ptj_arr[3]) : 0)
                            // });


                            //-- NEGATIVOS
                            $(targets.quizQuestions+' li.question.negativo').each(function(idx, ele){
                                var ptj = $(ele).attr('data-puntos');
                                //--
                                ptj = isNumeric(ptj) ? parseInt(ptj) : 0;
                                //ptj = parseInt(ptj);
                                //--
                                //console.log('->ptj itm I: '+ptj);
                                //--
                                ptj_tot_negativo += ptj;
                            });
                            //-- RECUENTO
                            //console.log("-> TOT "+ptj_tot_negativo);
                            //-- Pad 0 left
                            ptj_str = "";
                            ptj_str = pad(ptj_tot_negativo, 4, 0);
                            //console.log("-> TOT NEG "+ptj_str);
                            //--
                            ptj_arr = new Array();
                            ptj_arr = ptj_str.split("");
                            //console.dir(ptj_arr);


                            //--
                            $(".res_NO").html(ptj_tot_negativo);

                            // $(".res_NO").jCountdown("funcionX", {
                            //     a: (isNumeric(ptj_arr[0]) ? parseInt(ptj_arr[0]) : 0),
                            //     b: (isNumeric(ptj_arr[1]) ? parseInt(ptj_arr[1]) : 0),
                            //     c: (isNumeric(ptj_arr[2]) ? parseInt(ptj_arr[2]) : 0),
                            //     d: (isNumeric(ptj_arr[3]) ? parseInt(ptj_arr[3]) : 0)
                            // });

                        });
                    });
                }
                else
                {
                    plugin.method.completeQuiz();
                }
            },

            //-- Go back to the last question
            backToQuestion: function(backButton) {
                var questionLI = $($(backButton).parents('li.question')[0]),
                    answers    = questionLI.find('.answers');

                //-- Back to previous question
                if (answers.css('display') === 'block' ) {
                    var prevQuestion = questionLI.prev('.question');

                    questionLI.fadeOut(300, function() {
                        prevQuestion.removeClass('correctResponse');
                        prevQuestion.find('.responses, .responses li').hide()
                        prevQuestion.find('.answers').show();
                        prevQuestion.find('.checkAnswer').show();

                        // If response messaging hasn't been disabled or moved to completion, hide the next question button
                        // If it has been, we need nextQuestion visible so the user can move forward (there is no separate checkAnswer button)
                        if (!plugin.config.disableResponseMessaging && !plugin.config.completionResponseMessaging) {
                            prevQuestion.find('.nextQuestion').hide();
                        }

                        if (prevQuestion.attr('id') != 'question0') {
                            prevQuestion.find('.backToQuestion').show();
                        } else {
                            prevQuestion.find('.backToQuestion').hide();
                        }

                        prevQuestion.fadeIn(500);
                    });

                //-- Back to question from responses
                } 
                else
                {
                    questionLI.find('.responses').fadeOut(300, function(){
                        questionLI.removeClass('correctResponse');
                        questionLI.find('.responses li').hide();
                        answers.fadeIn(500);
                        questionLI.find('.checkAnswer').fadeIn(500);
                        questionLI.find('.nextQuestion').hide();

                        // if question is first, don't show back button on question
                        if (questionLI.attr('id') != 'question0') {
                            questionLI.find('.backToQuestion').show();
                        }
                        else
                        {
                            questionLI.find('.backToQuestion').hide();
                        }
                    });
                }
            },

            //-- Hides all questions, displays the final score and some conclusive information
            completeQuiz: function() {

                //--
                var
                score     = $('#' + selector + ' .correctResponse').length,
                levelRank = plugin.method.calculateLevel(score),
                levelText = levels[levelRank],
                ptj_arr = new Array(),
                ptj_str = "",
                niv_res = 'NIV_1',
                niv_res_val = '1';
                //--
                var ptj_tot_positivo = 0;
                var ptj_tot_negativo = 0;
                //--
                //console.info('PUNTAJES');

                //--  POSITIVOS
                $(targets.quizQuestions+' li.question.positivo').each(function(idx, ele){
                    var ptj = $(ele).attr('data-puntos');
                    //--
                    ptj = isNumeric(ptj) ? parseInt(ptj) : 0;
                    //ptj = parseInt(ptj);
                    //--
                    //console.log('->ptj itm I: '+ptj);
                    //--
                    ptj_tot_positivo += ptj;
                });

                //-- RECUENTO
                //console.log("-> TOT "+ptj_tot_positivo);
                //-- Pad 0 left
                ptj_str = "";
                ptj_str = pad(ptj_tot_positivo, 4, 0);
                //console.log("-> TOT POS "+ptj_str);
                //--
                ptj_arr = new Array();
                ptj_arr = ptj_str.split("");
                //console.dir(ptj_arr);

                //--
                $(".res_SI").html(ptj_tot_positivo);

                // //--
                // $(".res_SI").jCountdown("funcionX", {
                //  a: (isNumeric(ptj_arr[0]) ? parseInt(ptj_arr[0]) : 0),
                //  b: (isNumeric(ptj_arr[1]) ? parseInt(ptj_arr[1]) : 0),
                //  c: (isNumeric(ptj_arr[2]) ? parseInt(ptj_arr[2]) : 0),
                //  d: (isNumeric(ptj_arr[3]) ? parseInt(ptj_arr[3]) : 0)
                // });

                //-- NEGATIVOS
                $(targets.quizQuestions+' li.question.negativo').each(function(idx, ele){
                    var ptj = $(ele).attr('data-puntos');
                    //--
                    ptj = isNumeric(ptj) ? parseInt(ptj) : 0;
                    //ptj = parseInt(ptj);
                    //--
                    //console.log('->ptj itm I: '+ptj);
                    //--
                    ptj_tot_negativo += ptj;
                });

                //-- RECUENTO
                //console.log("-> TOT "+ptj_tot_negativo);
                //-- Pad 0 left
                ptj_str = "";
                ptj_str = pad(ptj_tot_negativo, 4, 0);
                //console.log("-> TOT NEG "+ptj_str);

                //--
                ptj_arr = new Array();
                ptj_arr = ptj_str.split("");
                //console.dir(ptj_arr);

                //--
                $(".res_NO").html(ptj_tot_positivo);

                // //--
                // $(".res_SI").jCountdown("funcionX", {
                //  a: (isNumeric(ptj_arr[0]) ? parseInt(ptj_arr[0]) : 0),
                //  b: (isNumeric(ptj_arr[1]) ? parseInt(ptj_arr[1]) : 0),
                //  c: (isNumeric(ptj_arr[2]) ? parseInt(ptj_arr[2]) : 0),
                //  d: (isNumeric(ptj_arr[3]) ? parseInt(ptj_arr[3]) : 0)
                // });


//              //--
//                var
//              score     = $('#' + selector + ' .correctResponse').length,
//              levelRank = plugin.method.calculateLevel(score),
//              levelText = levels[levelRank],
//              niv_res = 'NIV_1',
//              niv_res_val = '1';
//
//
//              var ptj_tot = 0;
//
//              //--
//              //console.info('PUNTAJES');
//              $(targets.quizQuestions+' li.question').each(function(idx, ele){
//                  var ptj = $(ele).attr('data-puntos');
//                  ptj = parseInt(ptj);
//
//                  //--
//                  //console.log('->ptj itm: '+ptj);
//
//                  //--
//                  ptj_tot += ptj;
//              });
//
//              //--
//              //console.info('->ptj tot: '+ptj_tot);
//
//              //--
//                if (plugin.method.inRange(1, 8, ptj_tot)) {
//                    niv_res = 'NIV_1';
//                    niv_res_val = '1';
//              } else if (plugin.method.inRange(9, 16, ptj_tot)) {
//                    niv_res = 'NIV_2';
//                    niv_res_val = '4';
//                } else if (plugin.method.inRange(17, 24, ptj_tot)) {
//                    niv_res = 'NIV_3';
//                    niv_res_val = '8';
//                }
//
//              //--
//              var mensaje     = user.name+" movi� el piso en un nivel "+niv_res_val+" en la escala MD. ¿Cuánto mueves el piso tu? Averígualo tomando el Sismógrafo MD";
//              var nombre      = RUTA_fbnombre;
//              var titulo      = RUTA_fbtitulo;
//              var descripcion = RUTA_fbdescripcion;
//              var enlace      = RUTA_fbenlace;
//              var imagen      = RUTA_fbimagen;
//
//              //--
//              if(niv_res_val == '8'){
//                  facebook_post2feed(mensaje, nombre, titulo, descripcion, enlace, imagen);
//              }
//
//              //--
//                $(targets.quizScore + ' span').html(score + ' / ' + questionCount);
//                $(targets.quizLevel + ' span').html(levelText);
//                $(targets.quizLevel).addClass('level' + levelRank);
//                $(targets.quizLevel).addClass(niv_res);

                //--
                // $(".res_SI").css({"top": "450px", "left": "100px"});
                // $(".res_SI_label").css({"top": "460px", "left": "315px", "color": "#000000"});

                //--
                // $(".res_NO").css({"top": "530px", "left": "100px"});
                // $(".res_NO_label").css({"top": "540px", "left": "315px", "color": "#000000"});

                //--
                $(targets.quizArea).fadeOut(300, function() {
                    //-- If response messaging is set to show upon quiz completion, show it
                    if (plugin.config.completionResponseMessaging && !plugin.config.disableResponseMessaging) {
                        $('#' + selector + ' .questions input').prop('disabled', true);
                        $('#' + selector + ' .questions .button, #' + selector + ' .questions .questionCount').hide();
                        $('#' + selector + ' .questions .question, #' + selector + ' .questions .responses').show();
                        $(targets.quizResults).append($('#' + selector + ' .questions')).fadeIn(500);
                    } else {
                        $(targets.quizResults).fadeIn(500);
                    }
                });
            },

            //-- Compares selected responses with true answers, returns true if they match exactly
            compareAnswers: function(trueAnswers, selectedAnswers) {
                //--
                if (trueAnswers.length != selectedAnswers.length) {
                    return false;
                }

                //--
                var trueAnswers     = trueAnswers.sort(),
                    selectedAnswers = selectedAnswers.sort();

                //--
                for (var i = 0, l = trueAnswers.length; i < l; i++) {
                    if (trueAnswers[i] !== selectedAnswers[i]) {
                        return false;
                    }
                }

                return true;
            },

            //-- Calculates knowledge level based on number of correct answers
            calculateLevel: function(correctAnswers) {
                var percent = correctAnswers / questionCount,
                    level   = 0;

                if (plugin.method.inRange(0, 0.20, percent)) {
                    level = 5;
                } else if (plugin.method.inRange(0.21, 0.40, percent)) {
                    level = 4;
                } else if (plugin.method.inRange(0.41, 0.60, percent)) {
                    level = 3;
                } else if (plugin.method.inRange(0.61, 0.80, percent)) {
                    level = 2;
                } else if (plugin.method.inRange(0.81, 1.00, percent)) {
                    level = 1;
                }

                return level;
            },

            //-- Determines if percentage of correct values is within a level range
            inRange: function(start, end, value) {
                if (value >= start && value <= end) {
                    return true;
                }
                return false;
            }
        }

        plugin.init = function() {
            //-- Setup quiz
            plugin.method.setupQuiz();

            //--
            $(".res_SI").css({display: "none" });
            $(".res_SI_label").css({display: "none" });

            //--
            $(".res_NO").css({display: "none" });
            $(".res_NO_label").css({display: "none" });

            //-- Bind "start" button
            $(triggers.starter).live('click', function(e) {
                e.preventDefault();
                plugin.method.iniQuiz(this);
                //--
                $(".res_SI").css({display: "block" });
                $(".res_SI_label").css({display: "block" });
                //--
                $(".res_NO").css({display: "block" });
                $(".res_NO_label").css({display: "block" });
            });

            //-- Bind "submit answer" button
            $(triggers.checker).live('click', function(e) {
                ////console.log('->CLIC: '+$(this).attr('class'));
                e.preventDefault();
                plugin.method.checkAnswer(this);
                //plugin.method.nextQuestion(this);
            });

            //-- Bind "back" button
            $(triggers.back).live('click', function(e) {
                e.preventDefault();
                plugin.method.backToQuestion(this);
            });

            //-- Bind "next question" button
            $(triggers.next).live('click', function(e) {
                e.preventDefault();
                plugin.method.nextQuestion(this);
            });

            //console.log("..."+targets.quizQuestions);

            //var NoClickRes = true;

            $(targets.quizQuestions).on("change", "li.activo input", function() {
                //console.log("...");

                var ele = $(this);
                var NoClickRes = true;
                var ResSel = $(targets.quizQuestions+' input:checked');

                if(ResSel.length > 0 ){
                    //$(targets.quizQuestions+' li.activo .nextQuestion').css({'display':'block'});
                    //-- Data Estatus
                    var data_estatus = $(targets.quizQuestions+' li.activo .nextQuestion').attr('data-estatus');
                    //-- Verifica
                    if(data_estatus == 'no_activo') {
                        $(targets.quizQuestions+' li.activo .nextQuestion').fadeIn(500, function(ele){
                            $(targets.quizQuestions+' li.activo .nextQuestion').attr('data-estatus', 'si_activo')
                        });
                    }
                }

                //console.info('->ResSel: '+ResSel.length);
                //myfunction($(this));
                //if(ele.is(':checked')) {
                //}
            });

//          $(targets.quizQuestions)
//          .off('li.activo', 'click')
//          .on('li.activo', 'click', function(){
//              var ResSel = $(targets.quizQuestions+'input:checked');
//              console.info('->ResSel: '+ResSel.length);
//          });

        }

        plugin.init();
    }

    $.fn.quized = function(options) {
        return this.each(function() {
            if (undefined == $(this).data('quized')) {
                var plugin = new $.quized(this, options);
                $(this).data('quized', plugin);
            }
        });
    }

})(jQuery);
