// Setup your quiz text and questions here

// NOTE: pay attention to commas, IE struggles with those bad boys

//-- Se mostrarán la cantidad de preguntas que sea menor a el siguiente valor
var quizCOUNT = 3;

var quizJSON =
{
    "info":
	{
        //"name":    "mueve",
        //"main":    "<p>¿ERES UNA MUJER QUE MUEVE EL PISO O UNA MUJER QUE SOLO CAMINA?</p>",
        //"results": "<p>Este es el texto que se muestra en al resultado</p>",
        "level1":  "NIVEL1",
        "level2":  "NIVEL2",
        "level3":  "NIVEL3"
    },
    "questions":
	[
        {
			//-- Question 1
            "q": "<span class=\"etiqueta\">PREGUNTA 1... </span>",
            "a":
			[
                {
					"id": "a",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">a</span><span class=\"etiqueta_texto\">Haces una lista de que necesitas para el viaje</span>",
					"correct": true,
					"categoria": 'PTJ_1',
					"positivo": true
				},
                {
					"id": "b",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">b</span><span class=\"etiqueta_texto\">Aceptas de inmediato</span>",
					"correct": false,
					"categoria": 'PTJ_2',
					"positivo": false
				},
                {
					"id": "c",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">c</span><span class=\"etiqueta_texto\">Te quedas silvando en la loma</span>",
					"correct": false,
					"categoria": 'PTJ_3',
					"positivo": false
				} // no comma here
            ],
            "correct": "<p><span>Correcto</span>VALIDA</p>",
            "incorrect": "<p><span>Incorrecto</span>INVALIDA</p>" // no comma here
        },
        {
			//-- Question 2
            "q": "<span class=\"etiqueta\">PREGUNTA 2</span>",
            "a":
			[
                {
					"id": "a",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">a</span><span class=\"etiqueta_texto\">Haces una lista de que neceistas para el viaje</span>",
					"correct": true,
					"categoria": 'PTJ_1',
					"positivo": false
				},
                {
					"id": "b",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">b</span><span class=\"etiqueta_texto\">Aceptas de inmediato</span>",
					"correct": false,
					"categoria": 'PTJ_2',
					"positivo": true
				},
                {
					"id": "c",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">c</span><span class=\"etiqueta_texto\">Te quedas silvando en la loma</span>",
					"correct": false,
					"categoria": 'PTJ_3',
					"positivo": false
				} // no comma here
            ],
            "correct": "<p><span>Correcto</span>VALIDA</p>",
            "incorrect": "<p><span>Incorrecto</span>INVALIDA</p>" // no comma here
        },
        {
			//-- Question 2
            "q": "<span class=\"etiqueta\">PREGUNTA 3</span>",
            "a":
			[
                {
					"id": "a",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">a</span><span class=\"etiqueta_texto\">Haces una lista de que neceistas para el viaje</span>",
					"correct": true,
					"categoria": 'PTJ_1',
					"positivo": false
				},
                {
					"id": "b",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">b</span><span class=\"etiqueta_texto\">Aceptas de inmediato</span>",
					"correct": false,
					"categoria": 'PTJ_2',
					"positivo": false
				},
                {
					"id": "c",
					"option": "<div class=\"icono\"></div><span class=\"etiqueta\">c</span><span class=\"etiqueta_texto\">Te quedas silvando en la loma</span>",
					"correct": false,
					"categoria": 'PTJ_3',
					"positivo": true
				} // no comma here
            ],
            "correct": "<p><span>Correcto</span>VALIDA</p>",
            "incorrect": "<p><span>Incorrecto</span>INVALIDA</p>" // no comma here
        } // no comma here
    ]
};

