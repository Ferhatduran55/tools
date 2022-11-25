function isset(accessor) {
    try {
        return accessor() !== undefined && accessor() !== null
    } catch (e) {
        return false
    }
}