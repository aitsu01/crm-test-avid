export function useColor() {
    const toRgba = (color: string, alpha = 1) => {
        const temp = document.createElement("div");
        temp.style.color = color;
        document.body.appendChild(temp);
        const computedColor = getComputedStyle(temp).color;
        document.body.removeChild(temp);
        const rgb = computedColor.match(/\d+/g).map(Number);
        const [r, g, b] = rgb;
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    return {
        toRgba,
    };
}
