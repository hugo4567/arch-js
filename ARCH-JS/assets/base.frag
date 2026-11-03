#version 300 es
precision mediump float;

in vec4 fColor;
in vec2 fTexCoords;

out vec4 FragColor;

uniform sampler2D uTexture;

void main()
{
    vec4 textureColor = texture(uTexture, fTexCoords);
    FragColor = textureColor * fColor;

    // Evite les halos et ombres residuels des pixels transparents de l'atlas.
    if (FragColor.a < 0.01) {
        discard;
    }
}